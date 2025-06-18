<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $dataPelanggan = Customer::count();
        $products = Product::count();
        $transactions = Transaction::count(); // Semua transaksi

        $orderDone = Transaction::whereRelation('evidencepayment', 'status', true)->count(); // Berhasil
        $orderIn = Transaction::whereRelation('evidencepayment', 'status', null)->count(); // Diproses

        // Transaksi dengan status pembayaran ditolak (false)
        $orderDecline = Transaction::whereHas('evidencepayment', function ($query) {
            $query->latest()->where('status', false);
        })->count();

        // Ambil customer yang ulang tahun hari ini
        $today = Carbon::now();
        $birthdayCustomers = Customer::whereMonth('birth_date', $today->month)
            ->whereDay('birth_date', $today->day)
            ->with('user')
            ->get();

        return view('admin.dashboard.index', [
            'dataPelanggan' => $dataPelanggan,
            'products' => $products,
            'transaction' => $transactions,
            'orderDone' => $orderDone,
            'orderIn' => $orderIn,
            'orderDecline' => $orderDecline,
            'birthdayCustomers' => $birthdayCustomers, // ← kirim ke blade
        ]);
    }
}
