<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="{{ asset('lp/img/favicon.png') }}" type="image/png" />
    <title>MIRASHOP | Selamat Datang di MiraShop</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('lp/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('lp/vendors/linericon/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('lp/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('lp/css/themify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('lp/css/flaticon.css') }}" />
    <link rel="stylesheet" href="{{ asset('lp/vendors/owl-carousel/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('lp/vendors/lightbox/simpleLightbox.css') }}" />
    <link rel="stylesheet" href="{{ asset('lp/vendors/nice-select/css/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('lp/vendors/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('lp/vendors/jquery-ui/jquery-ui.css') }}" />
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('lp/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('lp/css/responsive.css') }}" />

    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    {{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    @stack('style')

</head>

<body>

    @include('layouts.navhome')

    @yield('content')

    <!--================ start footer Area  =================-->
    <footer class="footer-area section_gap">
        <div class="container">
            {{-- <div class="row">
                <div class="col-lg-2 col-md-6 single-footer-widget">
                    <h4>Top Products</h4>
                    <ul>
                        <li><a href="#">Managed Website</a></li>
                        <li><a href="#">Manage Reputation</a></li>
                        <li><a href="#">Power Tools</a></li>
                        <li><a href="#">Marketing Service</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 single-footer-widget">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#">Jobs</a></li>
                        <li><a href="#">Brand Assets</a></li>
                        <li><a href="#">Investor Relations</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 single-footer-widget">
                    <h4>Features</h4>
                    <ul>
                        <li><a href="#">Jobs</a></li>
                        <li><a href="#">Brand Assets</a></li>
                        <li><a href="#">Investor Relations</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 single-footer-widget">
                    <h4>Resources</h4>
                    <ul>
                        <li><a href="#">Guides</a></li>
                        <li><a href="#">Research</a></li>
                        <li><a href="#">Experts</a></li>
                        <li><a href="#">Agencies</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 single-footer-widget">
                    <h4>Newsletter</h4>
                    <p>You can trust us. we only send promo offers,</p>
                    <div class="form-wrap" id="mc_embed_signup">
                        <form target="_blank"
                            action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
                            method="get" class="form-inline">
                            <input class="form-control" name="EMAIL" placeholder="Your Email Address"
                                onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your Email Address '"
                                required="" type="email">
                            <button class="click-btn btn btn-default">Subscribe</button>
                            <div style="position: absolute; left: -5000px;">
                                <input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value=""
                                    type="text">
                            </div>

                            <div class="info"></div>
                        </form>
                    </div>
                </div>
            </div> --}}
            <div class="footer-bottom row align-items-center">
                <p class="footer-text m-0 col-lg-8 col-md-12">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script> All rights reserved | This template is made with <i class="fa fa-heart-o"
                        aria-hidden="true"></i> by <a href="#" target="_blank">Andi Muhamad</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </p>
                <div class="col-lg-4 col-md-12 footer-social">
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-dribbble"></i></a>
                    <a href="#"><i class="fa fa-behance"></i></a>
                </div>
            </div>
        </div>
    </footer>
    <!--================ End footer Area  =================-->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('lp/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('lp/js/popper.js') }}"></script>
    <script src="{{ asset('lp/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('lp/js/stellar.js') }}"></script>
    <script src="{{ asset('lp/vendors/lightbox/simpleLightbox.min.js') }}"></script>
    <script src="{{ asset('lp/vendors/nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('lp/vendors/isotope/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('lp/vendors/isotope/isotope-min.js') }}"></script>
    <script src="{{ asset('lp/vendors/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lp/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('lp/vendors/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('lp/vendors/counter-up/jquery.counterup.js') }}"></script>
    <script src="{{ asset('lp/js/mail-script.js') }}"></script>
    <script src="{{ asset('lp/js/theme.js') }}"></script>

    @stack('script')
</body>

</html>
