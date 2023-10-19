<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Gp Bootstrap Template - Index</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('home') }}/assets/img/favicon.png" rel="icon">
    <link href="{{ asset('home') }}/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('home') }}/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="{{ asset('home') }}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('home') }}/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('home') }}/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="{{ asset('home') }}/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="{{ asset('home') }}/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="{{ asset('home') }}/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('home') }}/assets/css/style.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets') }}/dist/css/adminlte.min.css">
</head>

<body>
    @php
        use App\Helpers\MenuHelper;
        $user = auth()->user();
        $role = $user->getRole();
        $menus_nav = MenuHelper::getMenusByRole($role)->where('type', 'nav');
        $currentUrl = request()->path();
    @endphp

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container d-flex align-items-center justify-content-lg-between">

            {{-- <h1 class="logo me-auto me-lg-0"><a href="index.html">Gp<span>.</span></a></h1> --}}
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="{{ asset('home') }}/assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    @if (count($menus_nav) > 0)
                        @foreach ($menus_nav as $menu_nav)
                            <li {{ $currentUrl === url(url('/') . $menu_nav->link_menu) ? " class='active'" : '' }}><a
                                    class="nav-link" id="{{ 'nav-' . $menu_nav->kd_menu }}"
                                    href="{{ $menu_nav->link_menu }}">{{ $menu_nav->ur_menu_title }}</a></li>
                        @endforeach
                    @endif
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="get-started-btn" style="background: black">Logout</button>
            </form>

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center justify-content-center">
        <div class="container" data-aos="fade-up">

            @yield('content')

        </div>
    </section><!-- End Hero -->


    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>Gp</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/gp-free-multipurpose-html-bootstrap-template/ -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('home') }}/assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="{{ asset('home') }}/assets/vendor/aos/aos.js"></script>
    <script src="{{ asset('home') }}/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('home') }}/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="{{ asset('home') }}/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="{{ asset('home') }}/assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('home') }}/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('home') }}/assets/js/main.js"></script>

    <!-- jQuery -->
    <script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets') }}/dist/js/adminlte.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#menu-1').show();
            $('body').on('click', '#nav-5', function() {
                $('#menu-2').fadeIn(1000);
                $('#menu-3').hide();
            }).on('click', '#nav-4', function() {
                $('#menu-2').hide();
                $('#menu-3').fadeIn(1000);
            })
        });
    </script>

</body>

</html>
