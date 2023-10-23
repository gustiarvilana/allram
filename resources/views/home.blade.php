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
                <div class="col-xl-2 col-md-4" id="{{ 'menu-' . $menu->kd_menu }}" style="display: block">
                    <div class="icon-box">
                        <i class="{{ $menu->icon }}"></i>
                        <h3><a href="#" class="menu-link" data-redirect="{{ url('/') . $menu->link_menu }}"
                                data-link="{{ url('/') . '/utility/setsession' }}"
                                data-kd-menu="{{ $menu->kd_menu }}">{{ $menu->ur_menu_title }}</a></h3>

                    </div>
                </div>
            @endforeach
        @endif

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.menu-link').click(function(e) {
                    console.log('asd');
                    e.preventDefault();
                    var kdMenu = $(this).data('kd-menu');
                    var linkMenu = $(this).data('link');
                    var redirect = $(this).data('redirect');
                    $.ajax({
                        type: 'POST',
                        url: linkMenu,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            name: 'kd_home_parent',
                            val: kdMenu
                        },
                        success: function(data) {
                            window.location.href = redirect;
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                });
            });
        </script>

    </div>
@endsection
