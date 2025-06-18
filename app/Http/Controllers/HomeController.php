<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Home;
use App\Models\Product;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function landingpage()
    {
        $user = auth()->user();

        $productsPromo = Product::with('productpictures', 'promo')
            ->whereRelation('promo', function ($builder) {
                $builder->where('startdate', '<=', Carbon::now())
                    ->where('enddate', '>=', Carbon::now());
            })
            ->latest()
            ->get();

        $products = Product::with('productpictures', 'promo')
            ->latest()
            ->limit(3)
            ->get();

        // Default: jika belum login, tampilkan produk terlaris umum
        $recommendedProducts = Product::with('productpictures')
            ->select('products.*', DB::raw('SUM(details_transactions.qty) as total_sold'))
            ->leftJoin('details_transactions', 'products.id', '=', 'details_transactions.product_id')
            ->groupBy('products.id')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // Jika user login dan punya histori pembelian
        if ($user) {
            // Ambil produk yang pernah dibeli user
            $purchasedProductIds = DB::table('details_transactions')
                ->join('transactions', 'details_transactions.transaction_id', '=', 'transactions.id')
                ->where('transactions.user_id', $user->id)
                ->pluck('details_transactions.product_id');

            // Ambil kategori dari produk-produk tersebut
            $subCategoryIds = Product::whereIn('id', $purchasedProductIds)->pluck('subcategory_id')->unique();

            if ($subCategoryIds->isNotEmpty()) {
                // Ambil produk dari kategori yang sama, tapi belum dibeli user
                $recommendedProducts = Product::with('productpictures')
                    ->select('products.*', DB::raw('SUM(details_transactions.qty) as total_sold'))
                    ->leftJoin('details_transactions', 'products.id', '=', 'details_transactions.product_id')
                    ->whereIn('products.subcategory_id', $subCategoryIds)
                    ->whereNotIn('products.id', $purchasedProductIds)
                    ->groupBy('products.id')
                    ->inRandomOrder()
                    ->limit(4)
                    ->get();
            }
        }

        return view('home.index', [
            'products' => $products,
            'productsPromo' => $productsPromo,
            'recommendedProducts' => $recommendedProducts,
        ]);
    }


    public function promo(Request $request)
    {
        // Filter berdasarkan kategori atau subkategori jika ada
        $query = Product::with(['productpictures', 'promo' => function ($builder) {
            $builder->where('startdate', '<=', Carbon::now())->where('enddate', '>=', Carbon::now());
        }]);

        if (!is_null($request->category_id)) {
            $query->whereRelation('subcategory.category', 'id', $request->category_id);
        } elseif (!is_null($request->subcategory_id)) {
            $query->whereRelation('subcategory', 'id', $request->subcategory_id);
        }

        // Mendapatkan hanya produk yang memiliki promo aktif
        $products = $query->whereHas('promo', function ($builder) {
            $builder->where('startdate', '<=', Carbon::now())->where('enddate', '>=', Carbon::now());
        })->latest()->get();

        // Menghitung harga setelah diskon untuk setiap produk promo
        $productDiscount = $products->map(function ($item) {
            $item->discountprice = $item->price - ($item->price * $item->promo[0]->promo_discount / 100);
            $item->discount_percentage = $item->promo[0]->promo_discount;
            return $item;
        });

        // Mengambil data kategori dan subkategori
        $subcategories = Subcategory::query()->latest()->get();
        $categories = Category::with('subcategory')->latest()->get();

        // Mengirim data ke tampilan
        return view('home.promo', [
            'categories' => $categories,
            'subcategories' => $subcategories,
            'productDiscount' => $productDiscount
        ]);
    }





    public function index(Request $request)
    {
        $products = Product::with([
            'productpictures',
            'promo' => function ($builder) {
                $builder->where('startdate', '<=', Carbon::now())
                    ->where('enddate', '>=', Carbon::now());
            }
        ]);

        // Pencarian berdasarkan keyword
        if ($request->filled('q')) {
            $products = $products->where('productname', 'like', '%' . $request->q . '%');
        }

        // Filter berdasarkan category
        if (!is_null($request->category_id)) {
            $products = $products->whereRelation('subcategory.category', 'id', $request->category_id);
        }

        // Filter berdasarkan subcategory
        if (!is_null($request->subcategory_id)) {
            $products = $products->whereRelation('subcategory', 'id', $request->subcategory_id);
        }

        // Ambil produk dengan filter dan sorting
        $products = $products->latest()->get();

        // Hitung harga diskon jika ada promo
        $products->each(function ($product) {
            if ($product->promo && !$product->promo->isEmpty()) {
                $product->discountprice = $product->price - ($product->price * $product->promo[0]->promo_discount / 100);
            } else {
                $product->discountprice = $product->price;
            }
        });

        // Ambil semua kategori dan subkategori
        $subcategories = Subcategory::query()->latest()->get();
        $categories = Category::with('subcategory')->latest()->get();

        return view('home.shop', [
            'categories' => $categories,
            'subcategories' => $subcategories,
            'products' => $products
        ]);
    }



    public function showProducts($id)
    {

        $products = Product::with(['productpictures', 'subcategory.category', 'promo' => function ($builder) {
            $builder->where('startdate', '<=', Carbon::now())->where('enddate', '>=', Carbon::now());
        }])->find($id);

        if (!$products->promo->isEmpty()) {
            $products->discountprice = $products->price - ($products->price * $products->promo[0]->promo_discount / 100);
        }

        // dd($products->toArray());
        return view('home.showProducts', [
            'products' => $products
        ]);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Home $home)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Home $home)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Home $home)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Home $home)
    {
        //
    }

    public function editBiodata(Customer $customer)
    {
        return view('home.edit_biodata', compact('customer'));
    }

    public function updateBiodata(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $customer->user->id,
            'phone' => 'required',
            'address' => 'required'
        ]);

        $customer->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $customer->update([
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        return redirect()->back();
    }
}
