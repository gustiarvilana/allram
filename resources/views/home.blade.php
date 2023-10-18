@extends('layouts.home.master')

@section('content')
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container d-flex align-items-center justify-content-lg-between">

            {{-- <h1 class="logo me-auto me-lg-0"><a href="index.html">CV. RAM Armalia Abadi <span>.</span></a></h1> --}}
            <!-- Uncomment below if you prefer to use an image logo -->
            {{-- <a href="index.html" class="logo me-auto me-lg-0"><img src="{{ asset('home') }}/assets/img/logo.png" alt=""
                    class="img-fluid"></a> --}}

            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">RAM Armalia Abadi</a></li>
                    <li><a class="nav-link scrollto" href="#about">RAM Car Wash</a></li>
                    <li><a class="nav-link scrollto" href="#services">RAM Water</a></li>
                    <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                {{-- <button type="submit" class="get-started-btn scrollto">Logout</button> --}}
                <a type="submit" class="get-started-btn scrollto" style="color:'dark'">Logout</a>
            </form>

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center justify-content-center">
        <div class="container" data-aos="fade-up">

            <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="150">
                <div class="col-xl-8 col-lg-8">
                    <h1>CV. RAM Armalaia Abadi<span>.</span></h1>
                </div>
            </div>

            <div class="row gy-4 mt-5 justify-content-center" data-aos="zoom-in" data-aos-delay="250">
                <div class="col-xl-2 col-md-4">
                    <div class="icon-box">
                        <i class="ri-store-line"></i>
                        <h3><a href="">Lorem Ipsum</a></h3>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- End Hero -->
@endsection
