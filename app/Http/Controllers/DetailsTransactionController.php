<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DetailsTransaction;
use App\Models\EvidencePayment;
use App\Models\Point;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class DetailsTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function details(Request $request)
    {
        $customer = $request->user()->customer;

        if (!$customer) {
            abort(403, 'Customer tidak ditemukan');
        }

        $transactions = Transaction::with([
            'detailtransaction',
            'evidencepayment' => function ($query) {
                $query->latest();
            }
        ])
            ->where('customer_id', $customer->id)
            ->get()
            ->map(function ($item) {
                $totalPrice = 0;
                $totalQty = 0;

                foreach ($item->detailtransaction as $detail) {
                    $totalPrice += $detail->qty * $detail->price;
                    $totalQty += $detail->qty;
                }

                $item->totalPrice = $totalPrice;
                $item->totalQty = $totalQty;

                // Status pembayaran
                if ($item->evidencepayment->isEmpty()) {
                    $item->status = 'Belum Bayar';
                } else {
                    $latestPayment = $item->evidencepayment->first(); // sudah sorted by latest
                    if (is_null($latestPayment->status)) {
                        $item->status = 'Diproses';
                    } elseif ($latestPayment->status) {
                        $item->status = 'Berhasil';
                    } else {
                        $item->status = 'Ditolak';
                    }
                }

                return $item;
            });

        return view('home.Orders', [
            'details' => $transactions
        ]);
    }


    public function paymentSuccess($id)
    {
        $discount = request()->get('discount');
        $totalAfterDiscount = request()->get('total_after_discount');
        $usePoints = request()->get('use_points');

        $transaction = Transaction::where('id', $id)->where('customer_id', auth()->user()->customer->id)->first();

        $evidence = new EvidencePayment();
        $evidence->transaction_id = $transaction->id;
        $evidence->status = 1;  // Status pembayaran berhasil
        $evidence->url = '-';
        $evidence->reason = '-';
        $evidence->save();

        $transaction->discount = $discount;
        $transaction->total_payment = $totalAfterDiscount;
        $transaction->save();

        // kode pengurangan point dan penambahan point
        // Mengatur poin pengguna jika menggunakan poin
        $customer = auth()->user()->customer;

        if ($usePoints == 1) {
            // jika poin di gunakan
            $pointsUsed = floor($discount * 10); // Bulatkan (misal diskon 10% * 10 = 10 poin, jika diskon 100% * 10 = 1000 poin)
            // kurangi point
            // misal point awal 180 point, otomatis discon adalah 10% karena 100 poin = 10%
            // sehingganya jika diskon 10% * 10 = 100 poin maka 180 - 100 = 80
            $remainingPoints = max($customer->point->points - $pointsUsed, 0); // Kurangi poin yang digunakan

        } else {
            // jika tidak menggunakan poin
            // jika tidak pakai point atau usePoints == 0 maka sisa point 180
            $remainingPoints = $customer->point->points;
        }

        // Hitung poin yang didapat dari totalAfterDiscount
        $pointsEarned = floor($totalAfterDiscount / 5000); // 1 poin per 5k pembelian (pembulatan kebawah)
        // nilai point total
        $updatedPoints = $remainingPoints + $pointsEarned;

        // Perbarui poin pelanggan
        $customer->point->points = $updatedPoints;
        $customer->point->save();

        return redirect()->route('detailsOrder');
    }


    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'url' => 'required|image|mimes:jpeg,png,jpg|max:2048', // max 2MB (2048 KB)
            'transaction_id' => 'required'
        ], [
            'url.required' => 'File bukti pembayaran wajib diupload',
            'url.image' => 'File harus berupa gambar',
            'url.mimes' => 'Format file harus jpeg, png, atau jpg',
            'url.max' => 'Ukuran file maksimal 2MB',
        ]);

        try {
            $image = $request->file('url');
            $imageName = Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images-product/' . $imageName;
            Storage::disk('public')->put($imagePath, file_get_contents($image));

            EvidencePayment::create([
                'transaction_id' => $request->transaction_id,
                'url' => $imagePath
            ]);

            return redirect()->route('detailsOrder')->with('success', 'Bukti pembayaran berhasil diupload');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat upload bukti pembayaran');
        }
    }

    public function show(DetailsTransaction $detailsTransaction, $id)
    {
        // Ambil data transaksi berdasarkan ID dan customer yang sedang login
        $transaction = Transaction::with('detailtransaction')->where('id', $id)
            ->where('customer_id', auth()->user()->customer->id)
            ->first();

        if ($transaction->total_payment !== 0 && $transaction->evidencepayment->isNotEmpty()) {
            return redirect()->route('detailsOrder');
        }

        $totalPrice = 0;
        $discount = 0;
        foreach ($transaction->detailtransaction as $detail) {
            $totalPrice += $detail->qty * $detail->price;
        }

        // Diskon ulang tahun
        $birthdayDiscountPercent = 0;
        $user = auth()->user();
        $birthday = $user->customer->birth_date ? date('m-d', strtotime($user->customer->birth_date)) : null;
        $today = now()->format('m-d');

        if ($birthday === $today) {
            // cek apakah sudah ada transaksi lain hari ini
            $alreadyUsedBirthdayDiscount = Transaction::where('customer_id', $user->customer->id)
                ->whereDate('created_at', now()->toDateString())
                ->where('id', '!=', $transaction->id) // kecualikan transaksi yg sedang diproses
                ->exists();

            // Jika belum ada transaksi lain hari ini → kasih diskon
            if (!$alreadyUsedBirthdayDiscount) {
                $birthdayDiscountPercent = 10;
                $totalPrice -= ($totalPrice * $birthdayDiscountPercent / 100);
            }
        }

        // Diskon poin
        $usePoints = request()->get('use_points', false);
        $pointsDiscountPercent = 0;
        if ($usePoints == 'true') {
            $userPoints = $user->customer->point->points ?? 0;
            $maxDiscount = floor($userPoints / 100) * 10; // diskon 10% per 100 poin
            $pointsDiscountPercent = min($maxDiscount, 100);
            $totalPrice -= ($totalPrice * $pointsDiscountPercent / 100);
        }

        // Total setelah diskon, minimal 1 agar tidak 0
        $totalAfterDiscount = max(1, round($totalPrice, 0));

        //Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => rand(), // gunakan ID transaksi sebagai order_id
                'gross_amount' => $totalAfterDiscount == 0 ? 1 : $totalAfterDiscount, // total harga
            ],
            'customer_details' => [
                'first_name' => $transaction->customer->user->name,
                'email' => $transaction->customer->user->email,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $transaction->snap_token = $snapToken;
        $transaction->save();

        return view('home.evidence', compact(
            'transaction',
            'totalAfterDiscount',
            'usePoints',
            'birthdayDiscountPercent',
            'pointsDiscountPercent',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailsTransaction $detailsTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailsTransaction $detailsTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailsTransaction $detailsTransaction)
    {
        //
    }
}
