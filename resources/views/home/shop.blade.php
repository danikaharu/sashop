@extends('layouts.homelayout')
@section('content')
    <!--================Home Banner Area =================-->
    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content d-md-flex justify-content-between align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h2>Shop List</h2>
                        <p>Lihat Produk Untuk Kulitmu!</p>
                    </div>
                    <div class="page_link">
                        <a href="index.html">Home</a>
                        <a href="category.html">Shop</a>
                        <a href="category.html">All Products</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Home Banner Area =================-->
    <!--================Category Product Area =================-->
    <section class="cat_product_area section_gap">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-lg-9">
                    <div class="product_top_bar">
                        <div class="left_dorp">
                            <select class="sorting">
                                <option value="1">Default sorting</option>
                                <option value="2">Default sorting 01</option>
                                <option value="4">Default sorting 02</option>
                            </select>
                            <select class="show">
                                <option value="1">Show 12</option>
                                <option value="2">Show 14</option>
                                <option value="4">Show 16</option>
                            </select>
                        </div>
                    </div>

                    <div class="latest_product_inner">
                        <div class="row">
                            @foreach ($products as $product)
                                <div class="col-lg-4 col-md-6 mb-4"> <!-- Tambahkan class mb-4 untuk margin bottom -->
                                    <div class="single-product"
                                        style="height: 100%; display: flex; flex-direction: column; justify-content: space-between; border: 1px solid #eee; padding: 10px; border-radius: 8px;">
                                        <!-- Tambahkan padding dan border untuk memisahkan produk -->
                                        <div class="product-img" style="height: 200px; overflow: hidden;">
                                            @if (!$product->productpictures->isEmpty())
                                                @if ($product->productpictures->where('url', '!=', '')->isNotEmpty())
                                                    <img src="{{ 'storage/' . $product->productpictures->where('url', '!=', '')->first()->url }}"
                                                        alt=""
                                                        style="height: 100%; width: 100%; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('storage/images-product/coconut.png') }}"
                                                        alt=""
                                                        style="height: 100%; width: 100%; object-fit: cover;">
                                                @endif
                                            @endif
                                        </div>
                                        <div class="product-btm" style="padding-top: 15px;"> <!-- Tambahkan padding top -->
                                            <a href="{{ route('showProducts', ['id' => $product->id]) }}" class="d-block">
                                                <h4><strong>{{ $product->productname }}</strong></h4>
                                            </a>
                                            <div class="mt-3"
                                                style="display: flex; flex-direction: column; align-items: flex-start;">
                                                @if (isset($product->promo) && !$product->promo->isEmpty())
                                                    @php
                                                        $discount_percentage = round(
                                                            (($product->price - $product->discountprice) /
                                                                $product->price) *
                                                                100,
                                                        );
                                                    @endphp

                                                    <div style="display: flex; align-items: baseline;">
                                                        <span
                                                            style="font-size: 0.9em; color: grey; text-decoration: line-through; margin-right: 8px;">
                                                            Rp. {{ number_format($product->price, 0) }}
                                                        </span>
                                                        <span style="color: green; font-size: 0.85em;">
                                                            ({{ $discount_percentage }}% OFF)
                                                        </span>
                                                    </div>

                                                    <div
                                                        style="font-weight: bold; font-size: 1.2em; color: #000; margin-top: 5px;">
                                                        Rp. {{ number_format($product->discountprice, 0) }}
                                                    </div>
                                                @else
                                                    <span style="font-size: 1.1em; font-weight: bold;">
                                                        Rp. {{ number_format($product->price, 0) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="left_sidebar_area">
                        <aside class="left_widgets p_filter_widgets">
                            <div class="l_w_title">
                                <h3>Cari Produk</h3>
                            </div>
                            <div class="widgets_inner">
                                <form action="{{ route('home.index') }}" method="GET" class="d-flex" style="gap: 5px;">
                                    <input type="text" name="q" class="form-control form-control-sm"
                                        placeholder="Cari produk..." value="{{ request('q') }}">
                                    <button type="submit" class="btn btn-sm btn-success">Cari</button>
                                </form>
                            </div>
                        </aside>


                        <aside class="left_widgets p_filter_widgets">
                            <div class="l_w_title">
                                <h3>Kategori</h3>
                            </div>
                            <div class="widgets_inner">
                                <ul class="list">
                                    @foreach ($categories as $category)
                                        <li>
                                            <a
                                                href="{{ route('home.index', ['category_id' => $category->id]) }}">{{ $category->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </aside>

                        <aside class="left_widgets p_filter_widgets">
                            <div class="l_w_title">
                                <h3>Subcategories</h3>
                            </div>
                            <div class="widgets_inner">
                                <ul class="list">
                                    @foreach ($subcategories as $subcategory)
                                        <li>
                                            <a href="{{ route('home.index', ['subcategory_id' => $subcategory->id]) }}">{{ $subcategory->category->name }}
                                                | {{ $subcategory->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Category Product Area =================-->
@endsection
