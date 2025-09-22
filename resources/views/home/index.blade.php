@extends('layouts.homelayout')
@section('content')
    <!--================Home Banner Area =================-->
    <section class="home_banner_area mb-40">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content row">
                    <div class="col-lg-12">
                        <p class="sub text-uppercase" style="color: rgb(101, 219, 4)">SKIN HEALTH</p>
                        <h3 style="color: rgb(0, 0, 0)"><span>Tampil</span> Dengan <br />Persona <span>Alami</span></h3>
                        <h4 style="color: rgb(87, 87, 87)">Fowl saw dry which a above together place.</h4>
                        <a class=" mt-40" href="{{ route('home.index') }}">View Collection</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Home Banner Area =================-->

    <!--================ New Product Section =================-->
    <section class="new_product_area mb-40">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center">
                    <div class="new_product_content">
                        <h3 class="text-uppercase mb-40">Produk Baru</h3>
                        <div class="new-products d-flex justify-content-center gap-3">
                            @foreach ($products as $product)
                                <a href="{{ route('showProducts', ['id' => $product->id]) }}"
                                    class="single-new-product-link">
                                    <div class="single-new-product">
                                        <span class="new-product-label">New Product</span>
                                        <div class="product-image">
                                            <img src="{{ $product->productpictures->isNotEmpty() ? 'storage/' . $product->productpictures->first()?->url : asset('asset/logoFic.jpg') }}"
                                                alt="{{ $product->productname }}">
                                        </div>
                                        <h5 class="product-name mt-3">{{ $product->productname }}</h5>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ End New Product Section =================-->


    <!--================ Promo Product Slider =================-->
    <section class="offer_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center">
                    <div class="offer_content">
                        <h3 class="text-uppercase mb-40">PROMO PRODUCTS</h3>
                        <div class="promo-slider-wrapper">
                            <div id="promo-slider" class="promo-slider">
                                @foreach ($productsPromo as $product)
                                    <div class="single-promo text-center p-3">
                                        @foreach ($product->promo as $discount)
                                            <div class="promo-discount mb-3">
                                                <h2 class="text-uppercase">{{ $discount->promo_discount }}%</h2>
                                            </div>
                                        @endforeach
                                        <p class="mb-3">Limited Time Offer</p>
                                        <a href="{{ route('home.promo') }}" class="main_btn mb-20 mt-5">Discover Now</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="slider-controls">
                            <button id="prev-slide">&#10094;</button>
                            <button id="next-slide">&#10095;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ End Promo Product Slider =================-->

    <!--================ Recommended Products =================-->
    <section class="new_product_area mb-40">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center">
                    <div class="new_product_content">
                        <h3 class="text-uppercase mb-40">Rekomendasi Untukmu</h3>
                        <div class="new-products d-flex justify-content-center gap-3">
                            @foreach ($recommendedProducts as $product)
                                <a href="{{ route('showProducts', ['id' => $product->id]) }}"
                                    class="single-new-product-link">
                                    <div class="single-new-product">
                                        <div class="product-image">
                                            <img src="{{ $product->productpictures->isNotEmpty() ? 'storage/' . $product->productpictures->first()?->url : asset('asset/logoFic.jpg') }}"
                                                alt="{{ $product->productname }}">
                                        </div>
                                        <h5 class="product-name mt-3">{{ $product->productname }}</h5>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ End Recommended Products =================-->


    <!-- CSS untuk styling slider dan kontrol -->
    <style>
        /* Styling untuk section produk baru */
        .new_product_area {
            padding: 60px 0;
            background: #ffffff;
        }

        .new_product_content h3 {
            font-size: 1.8em;
            color: #333;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .new-products {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .single-new-product {
            width: 200px;
            background: #f9f9f9;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            position: relative;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            height: 100%;
        }

        .single-new-product:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        .new-product-label {
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            background: #82ae46;
            color: #ffffff;
            padding: 5px 10px;
            font-size: 0.8em;
            font-weight: bold;
            border-radius: 12px;
        }

        .product-image img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-name {
            font-size: 1em;
            font-weight: 600;
            color: #333;
            margin-top: 10px;
        }

        /* Styling dasar untuk offer area */
        .offer_area {
            padding: 60px 0;
            background: #f0f0f0;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }

        .promo-slider-wrapper {
            display: flex;
            justify-content: center;
            width: 100%;
            max-width: 1000px;
            margin: auto;
            overflow: hidden;
            position: relative;
        }

        .promo-slider {
            display: flex;
            transition: transform 0.4s ease-in-out;
            gap: 20px;
            will-change: transform;
        }

        .single-promo {
            flex: 0 0 260px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: all 0.3s ease;
        }

        .single-promo:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .promo-discount h2 {
            font-size: 2.5em;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .limited-offer {
            font-size: 1em;
            color: #888;
            margin-bottom: 20px;
        }

        .main_btn {
            display: inline-block;
            padding: 12px 24px;
            background: #82ae46;
            color: white;
            border-radius: 5px;
            font-size: 1em;
            font-weight: 600;
            text-transform: uppercase;
            transition: background 0.3s ease;
            margin-top: auto;
            width: 100%;
            max-width: 160px;
        }

        .main_btn:hover {
            background: #6f9339;
            text-decoration: none;
        }

        .slider-controls {
            text-align: center;
            margin-top: 20px;
        }

        .slider-controls button {
            background: transparent;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
            padding: 10px;
            transition: color 0.3s ease;
        }

        .slider-controls button:hover {
            color: #82ae46;
        }

        .recommended_product_area {
            background-color: #f9f9f9;
            padding: 50px 0;
        }

        .recommended_product_area h3 {
            font-weight: 600;
            font-size: 1.8rem;
        }

        .recommended_product_area .single-new-product {
            transition: transform 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
        }

        .recommended_product_area .single-new-product:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const slider = document.querySelector("#promo-slider");
            const slides = document.querySelectorAll(".single-promo");
            const slideCount = slides.length;
            const visibleSlides = 3; // Jumlah slide yang ditampilkan sekaligus
            let currentIndex = 0;

            // Animasi Zoom In-Out untuk box promo
            function animateSlide() {
                slides.forEach((slide, index) => {
                    slide.style.transition = "transform 0.5s ease, box-shadow 0.5s ease";
                    slide.style.transform = "scale(1)"; // Reset ukuran slide
                    slide.style.boxShadow = "0 4px 12px rgba(0, 0, 0, 0.1)";
                });

                const activeSlide = slides[currentIndex];
                activeSlide.style.transform = "scale(1.05)"; // Membesar sedikit
                activeSlide.style.boxShadow = "0 8px 20px rgba(0, 0, 0, 0.2)";
            }

            // Fungsi untuk berpindah ke slide sebelumnya
            document.querySelector("#prev-slide").addEventListener("click", function() {
                currentIndex = (currentIndex <= 0) ? slideCount - visibleSlides : currentIndex - 1;
                updateSlider();
                animateSlide();
            });

            // Fungsi untuk berpindah ke slide berikutnya
            document.querySelector("#next-slide").addEventListener("click", function() {
                currentIndex = (currentIndex >= slideCount - visibleSlides) ? 0 : currentIndex + 1;
                updateSlider();
                animateSlide();
            });

            // Fungsi untuk memperbarui posisi slider
            function updateSlider() {
                const slideWidth = slides[0].offsetWidth + 20; // Menyesuaikan dengan margin antar slide
                slider.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
            }

            // Auto-slide setiap 3 detik dengan animasi zoom in-out
            setInterval(function() {
                document.querySelector("#next-slide").click();
            }, 3000); // Ubah interval sesuai kebutuhan

            // Memanggil animasi pertama kali saat halaman dimuat
            animateSlide();
        });
    </script>
@endsection
