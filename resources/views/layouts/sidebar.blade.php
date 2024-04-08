@php
    $roleCheck = Auth::user()->role;

    $sidebarMenu = [
        [
            'headerName' => 'dashboard',
            'menus' => [
                [
                    'accessor' => ['admin', 'user'],
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
                    'accessor' => ['admin', 'user'],
                    'name' => 'locations',
                    'isDropdown' => true,
                    'icon' => 'fas fa-map-marked-alt',
                    'links' => [
                        [
                            'navName' => 'list location',
                            'link' => 'route()',
                            'accessor' => ['admin', 'user'],
                        ],
                        [
                            'navName' => 'add new location',
                            'link' => 'route()',
                            'accessor' => ['admin', 'gov'],
                        ],
                    ],
                ],
            ],
        ],
    ];
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
            @foreach ($sidebarMenu as $item)
                <li class="menu-header">{{ $item['headerName'] }}</li>
                @foreach ($item['menus'] as $menu)
                    @if (in_array($roleCheck, $menu['accessor']))
                        @if ($menu['isDropdown'])
                            <li class="dropdown {{ strtolower($page) == strtolower($menu['name']) ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="{{ $menu['icon'] }}"></i>
                                    <span>{{ $menu['name'] }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach ($menu['links'] as $menu)
                                        @if (in_array($roleCheck, $menu['accessor']))
                                            <li
                                                class="{{ strtolower($subPage) == strtolower($menu['navName']) ? 'active' : '' }}">
                                                <a class="nav-link"
                                                    href="{{ $menu['link'] }}">{{ $menu['navName'] }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            @foreach ($menu['links'] as $menu)
                                @if (in_array($roleCheck, $menu['accessor']))
                                    <li class="{{ strtolower($page) == strtolower($menu['navName']) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ $menu['link'] }}">
                                            <i class="{{ $menu['icon'] }}"></i>
                                            <span class="text-capitalize">{{ $menu['navName'] }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endif
                @endforeach
            @endforeach
        </ul>
    </aside>
</div>
