@extends('layouts.home.master')

@section('content')
    @php
        use App\Helpers\MenuHelper;
        $user = auth()->user();
        $role = $user->getRole();
        $menus = MenuHelper::getMenusByRole($role)
            ->where('kd_parent', '==', 0)
            ->where('type', '!=', 'nav');
        $currentUrl = request()->url();
    @endphp

    <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="150">
        <div class="col-xl-8 col-lg-8">
            <h1>CV<span>.</span> RAM Armalia Abadi</h1>
            {{-- <h2>We are team of talented digital marketers</h2> --}}
        </div>
    </div>

    <div class="row gy-4 mt-5 justify-content-center" data-aos="zoom-in" data-aos-delay="250">

        @if (count($menus))
            @foreach ($menus as $menu)
                <div class="col-xl-2 col-md-4" id="{{ 'menu-' . $menu->kd_menu }}" style="display: none">
                    <div class="icon-box">
                        <i class="{{ $menu->icon }}"></i>
                        <h3><a href="{{ url('/') . $menu->link_menu }}">{{ $menu->ur_menu_title }}</a></h3>
                    </div>
                </div>
            @endforeach
        @endif

    </div>
@endsection
