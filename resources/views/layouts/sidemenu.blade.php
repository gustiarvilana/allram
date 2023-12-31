@if (count($menus) > 0)
    {{-- <li class="nav-header">
        <h4>Security</h4>
    </li> --}}

    @foreach ($menus as $menu)
        @php
            $count_child = MenuHelper::countChildren($menu->kd_menu)->where('kd_parent', '!=', null);
        @endphp
        <li class="nav-item" id="item_menu-{{ $menu->kd_menu }}">
            {{-- <li class="nav-item menu-is-opening menu-open"> --}}
            <a href="{{ url('/') . $menu->link_menu }}"
                class="nav-link @if ('/' . $currentUrl == $menu->link_menu) active @endif>{{ $menu->ur_menu_title }}">
                <i class="nav-icon {{ $menu->icon }}"></i>
                <p>
                    {{ $menu->ur_menu_title }}
                    @if (count($count_child) > 0)
                        <i class="right fas fa-angle-left"></i>
                    @endif
                </p>
            </a>

            @if (count($count_child) > 0)
                @php
                    MenuHelper::printChildren($menu->kd_menu, $currentUrl, $parentUrl);
                @endphp
            @endif
        </li>
    @endforeach
@endif
