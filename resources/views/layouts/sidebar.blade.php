@php
    $roleCheck = Auth::user()->role;
    $sidebar = [];

    if ($roleCheck == 'admin') {
        $sidebar = [
            [
                'headerName' => 'dashboard',
                'menus' => [
                    [
                        'name' => 'Dashboard',
                        'isDropdown' => false,
                        'links' => [
                            [
                                'icon' => 'fas fa-fire',
                                'navName' => 'dashboard',
                                'link' => 'route()',
                                'accessor' => ['admin', 'user'],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'headerName' => 'master',
                'menus' => [
                    [
                        'name' => 'Menu name',
                        'isDropdown' => true,
                        'icon' => 'fas fa-map-marked-alt',
                        'links' => [
                            [
                                'navName' => 'Menus',
                                'link' => 'route()',
                                'accessor' => ['admin', 'user'],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    if ($roleCheck == 'user') {
        $sidebar = [
            [
                'headerName' => 'dashboard',
                'menus' => [
                    [
                        'name' => 'Dashboard',
                        'isDropdown' => false,
                        'links' => [
                            [
                                'icon' => 'fas fa-fire',
                                'navName' => 'dashboard',
                                'link' => 'route()',
                                'accessor' => ['admin', 'user'],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
@endphp

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">App Name</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">App</a>
        </div>
        <ul class="sidebar-menu text-capitalize">
            @foreach ($sidebar as $item)
                <li class="menu-header">{{ $item['headerName'] }}</li>
                @foreach ($item['menus'] as $menu)
                    @if ($menu['isDropdown'])
                        <li class="dropdown {{ strtolower($page) == strtolower($menu['name']) ? 'active' : '' }}">
                            <a href="#" class="nav-link has-dropdown">
                                <i class="{{ $menu['icon'] }}"></i>
                                <span>{{ $menu['name'] }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($menu['links'] as $menu)
                                    <li
                                        class="{{ strtolower($subPage) == strtolower($menu['navName']) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ $menu['link'] }}">{{ $menu['navName'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        @foreach ($menu['links'] as $menu)
                            <li class="{{ strtolower($page) == strtolower($menu['navName']) ? 'active' : '' }}">
                                <a class="nav-link" href="{{ $menu['link'] }}">
                                    <i class="{{ $menu['icon'] }}"></i>
                                    <span class="text-capitalize">{{ $menu['navName'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    @endif
                @endforeach
            @endforeach
        </ul>
    </aside>
</div>
