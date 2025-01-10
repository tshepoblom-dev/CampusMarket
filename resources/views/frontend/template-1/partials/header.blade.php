<header class="header-area style-1">
    <div class="header-logo">
        <a href="{{ url('/') }}">
            @if (get_setting('header_logo'))
                <img src="{{ asset('assets/logo/' . get_setting('header_logo')) }}" alt="Logo">
            @else
                <img src="{{ asset('frontend/images/bg/header-logo.png') }}" alt="Logo">
            @endif
        </a>
    </div>
    <div class="main-menu">
        <div class="mobile-logo-area d-lg-none d-flex justify-content-between align-items-center">
            <div class="mobile-logo-wrap ">
                <a href="{{ url('/') }}">
                    @if (get_setting('header_logo'))
                        <img src="{{ asset('assets/logo/' . get_setting('header_logo')) }}" alt="Logo">
                    @else
                        <img src="{{ asset('frontend/images/bg/header-logo.png') }}" alt="Logo">
                    @endif
                </a>

            </div>
            <div class="menu-close-btn">
                <i class="bi bi-x-lg"></i>
            </div>
        </div>
        @php
            $menu_items = \App\Models\MenuItem::with('page', 'category', 'blog')
                ->where('menu_id', 1)
                ->where('parent_id', null)
                ->orderBy('order', 'asc')
                ->get();

        @endphp
        @if ($menu_items->count() > 0)
            <ul class="menu-list">
                @foreach ($menu_items as $menu_item)
                    @if ($menu_item->children->count() > 0)
                        <li class="menu-item-has-children">
                            <a target="{{ $menu_item->menu_type == 'custom' ? ($menu_item->new_tap == 1 ? '__blank' : '') : '' }}"
                                href="@if ($menu_item->menu_type == 'page') {{ $menu_item->slug == 'home' ? url('/') : url($menu_item->slug) }}@elseif($menu_item->menu_type == 'custom'){{ $menu_item->target }}@elseif($menu_item->menu_type == 'category'){{ url('/category/' . $menu_item->slug) }}@else{{ url('/blog/' . $menu_item->slug) }} @endif"
                                class="drop-down">

                                @if ($menu_item->menu_type == 'page')
                                    {{ $menu_item?->page?->getTranslation('page_name') }}
                                @elseif ($menu_item->menu_type == 'category')
                                    {{ $menu_item->category->getTranslation('name') }}
                                @elseif ($menu_item->menu_type == 'blog')
                                    {{ $menu_item?->blog?->getTranslation('title') }}
                                @else
                                    {{ Str::limit($menu_item->getTranslation('title'), 15) }}
                                @endif



                            </a>
                            <i class='bx bx-plus dropdown-icon'></i>

                            <ul class="submenu">
                                @foreach ($menu_item->children as $subMenu)
                                    @if ($subMenu->children->count() > 0)
                                        <li class="menu-item-has-children">
                                            <a class="@if ($menu_item->menu_type == 'page') {{ ($menu_item->slug == 'home' ? (request()->is('/') ? 'active' : '') : request()->is($menu_item->slug)) ? 'active' : '' }}
                                            @elseif($menu_item->menu_type == 'category') {{ request()->segment(2) == $menu_item->slug ? 'active' : '' }}
                                            @elseif($menu_item->menu_type == 'blog') {{ request()->segment(2) == $menu_item->slug ? 'active' : '' }} @else {{ request()->is($menu_item->slug) ? 'active' : '' }} @endif
                                          "
                                                target="{{ $menu_item->menu_type == 'custom' ? ($menu_item->new_tap == 1 ? '__blank' : '') : '' }}"
                                                href="@if ($subMenu->menu_type == 'page') {{ $subMenu->slug == 'home' ? url('/') : url($subMenu->slug) }}@elseif($subMenu->menu_type == 'custom'){{ $subMenu->target }}@elseif($subMenu->menu_type == 'category'){{ url('/category/' . $subMenu->slug) }}@else{{ url('/blog/' . $subMenu->slug) }} @endif"
                                                class="drop-down">

                                                @if ($subMenu->menu_type == 'page')
                                                    {{ $subMenu?->page?->getTranslation('page_name') }}
                                                @elseif ($subMenu->menu_type == 'category')
                                                    {{ $subMenu->category->getTranslation('name') }}
                                                @elseif ($subMenu->menu_type == 'blog')
                                                    {{ $subMenu?->blog?->getTranslation('title') }}
                                                @else
                                                    {{ Str::limit($subMenu->getTranslation('title'), 15) }}
                                                @endif

                                            </a><i class='bx bx-plus dropdown-icon'></i>
                                            <ul class="submenu">
                                                @foreach ($subMenu->children as $subSubMenu)
                                                    <li><a class=" @if ($menu_item->menu_type == 'page') {{ ($menu_item->slug == 'home' ? (request()->is('/') ? 'active' : '') : request()->is($menu_item->slug)) ? 'active' : '' }}
                                                        @elseif($menu_item->menu_type == 'category') {{ request()->segment(2) == $menu_item->slug ? 'active' : '' }}
                                                        @elseif($menu_item->menu_type == 'blog') {{ request()->segment(2) == $menu_item->slug ? 'active' : '' }} @else {{ request()->is($menu_item->slug) ? 'active' : '' }} @endif
                                                      "
                                                            target="{{ $menu_item->menu_type == 'custom' ? ($menu_item->new_tap == 1 ? '__blank' : '') : '' }}"
                                                            href="@if ($subSubMenu->menu_type == 'page') {{ $subSubMenu->slug == 'home' ? url('/') : url($subSubMenu->slug) }}@elseif($subSubMenu->menu_type == 'custom'){{ $subSubMenu->target }}@elseif($subSubMenu->menu_type == 'category'){{ url('/category/' . $subSubMenu->slug) }}@else{{ url('/blog/' . $subSubMenu->slug) }} @endif">

                                                            @if ($subSubMenu->menu_type == 'page')
                                                                {{ $subSubMenu?->page?->getTranslation('page_name') }}
                                                            @elseif ($subSubMenu->menu_type == 'category')
                                                                {{ $subSubMenu->category->getTranslation('name') }}
                                                            @elseif ($subSubMenu->menu_type == 'blog')
                                                                {{ $subSubMenu?->blog?->getTranslation('title') }}
                                                            @else
                                                                {{ Str::limit($subSubMenu->getTranslation('title'), 15) }}
                                                            @endif

                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        <li><a class=" @if ($menu_item->menu_type == 'page') {{ ($menu_item->slug == 'home' ? (request()->is('/') ? 'active' : '') : request()->is($menu_item->slug)) ? 'active' : '' }} @elseif($menu_item->menu_type == 'category') {{ request()->segment(2) == $menu_item->slug ? 'active' : '' }}@elseif($menu_item->menu_type == 'blog') {{ request()->segment(2) == $menu_item->slug ? 'active' : '' }} @else {{ request()->is($menu_item->slug) ? 'active' : '' }} @endif"
                                                href="
                                                @if ($subMenu->menu_type == 'page') {{ $subMenu->slug == 'home' ? url('/') : url($subMenu->slug) }}
                                                @elseif($subMenu->menu_type == 'custom')
                                                {{ $subMenu->target }}
                                                @elseif($subMenu->menu_type == 'category')
                                                {{ url('/category/' . $subMenu->slug) }}
                                                @else{{ url('/blog/' . $subMenu->slug) }} @endif"
                                                target="{{ $menu_item->menu_type == 'custom' ? ($menu_item->new_tap == 1 ? '__blank' : '') : '' }}">

                                                @if ($subMenu->menu_type == 'page')
                                                    {{ $subMenu?->page?->getTranslation('page_name') }}
                                                @elseif ($subMenu->menu_type == 'category')
                                                    {{ $subMenu->category->getTranslation('name') }}
                                                @elseif ($subMenu->menu_type == 'blog')
                                                    {{ $subMenu?->blog?->getTranslation('title') }}
                                                @else
                                                    {{ Str::limit($subMenu->getTranslation('title'), 15) }}
                                                @endif

                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li>
                            <a class="@if ($menu_item->menu_type == 'page') {{ ($menu_item->slug == 'home' ? (request()->is('/') ? 'active' : '') : request()->is($menu_item->slug)) ? 'active' : '' }} @elseif($menu_item->menu_type == 'category') {{ request()->segment(2) == $menu_item->slug ? 'active' : '' }} @elseif($menu_item->menu_type == 'blog') {{ request()->segment(2) == $menu_item->slug ? 'active' : '' }} @else {{ request()->is($menu_item->slug) ? 'active' : '' }} @endif"
                                target="{{ $menu_item->menu_type == 'custom' ? ($menu_item->new_tap == 1 ? '__blank' : '') : '' }}"
                                href="@if ($menu_item->menu_type == 'page') {{ $menu_item->slug == 'home' ? url('/') : url($menu_item->slug) }}@elseif($menu_item->menu_type == 'custom'){{ $menu_item->target }}@elseif($menu_item->menu_type == 'category'){{ url('/category/' . $menu_item->slug) }}@else{{ url('/blog/' . $menu_item->slug) }} @endif">

                                @if ($menu_item->menu_type == 'page')
                                    {{ $menu_item?->page?->getTranslation('page_name') }}
                                @elseif ($menu_item->menu_type == 'category')
                                    {{ $menu_item->category->getTranslation('name') }}
                                @elseif ($menu_item->menu_type == 'blog')
                                    {{ $menu_item?->blog?->getTranslation('title') }}
                                @else
                                    {{ Str::limit($menu_item->getTranslation('title'), 15) }}
                                @endif

                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif
        <!-- mobile-search-area -->
        <div class="d-lg-none d-block">
            <div>
                @if (Auth::check() && Auth::user()->role == 1)
                    <a class="eg-btn btn--primary header-btn2" href="{{ route('customer.dashboard') }}">{{ translate('My Account') }}</a>
                @elseif(
                    (Auth::check() && Auth::user()->role == 2) ||
                        (Auth::check() && Auth::user()->role == 3) ||
                        (Auth::check() && Auth::user()->role == 4))
                    <a class="eg-btn btn--primary header-btn2" href="{{ route('backend.dashboard') }}">{{ translate('My Account') }}</a>
                @else
                    <a class="eg-btn btn--primary header-btn2" href="{{ route('login') }}">{{ translate(get_setting('login_btn')) }}</a>
                @endif
            </div>
            <ul class="authontication-btn-group">
                @if (Auth::guest())
                <li><a class="eg-btn btn--primary sign-up" href="{{ route('register') }}">{{ translate(get_setting('customer_btn')) }}</a></li>
                <li><a class="eg-btn btn--primary marchant-btn" href="{{ route('merchant.register.show') }}">{{ translate(get_setting('marchant_btn')) }}</a></li>
            @else
                <li><a class="logout" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">{{ translate('Logout') }}</a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endif
            </ul>
            <form class="mobile-menu-form mb-5" action="{{ route('main.search') }}" method="post">
                @csrf
                <div class="input-with-btn d-flex">
                    <input type="text" name="search" placeholder="{{ translate('Search here') }}...">
                    <button type="submit" class="eg-btn btn--primary btn--sm"><i class="bi bi-search"></i></button>
                </div>
            </form>
            @if (get_setting('hotline_text') && get_setting('hotline_phone'))
                <div class="hotline two">
                    <div class="hotline-info">
                        <span>{{ get_setting('hotline_text') }}</span>
                        <h6><a href="tel:{{ get_setting('hotline_phone') }}">{{ get_setting('hotline_phone') }}</a>
                        </h6>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="nav-right d-flex align-items-center">
        @if (get_setting('hotline_text') && get_setting('hotline_phone'))
            <div class="hotline d-xxl-flex d-none">
                <div class="hotline-icon">
                    <img alt="image" src="{{ asset('frontend/images/icons/header-phone.svg') }}">
                </div>
                <div class="hotline-info">
                    <span>{{ get_setting('hotline_text') }}</span>
                    <h6><a href="tel:{{ get_setting('hotline_phone') }}">{{ get_setting('hotline_phone') }}</a></h6>
                </div>
            </div>
        @endif
        <div class="search-btn">
            <i class="bi bi-search"></i>
        </div>
        <div>
            @if (Auth::check() && Auth::user()->role == 1)
                <a class="eg-btn btn--primary header-btn" href="{{ route('customer.dashboard') }}">{{ translate('My Account') }}</a>
            @elseif(
                (Auth::check() && Auth::user()->role == 2) ||
                    (Auth::check() && Auth::user()->role == 3) ||
                    (Auth::check() && Auth::user()->role == 4))
                <a class="eg-btn btn--primary header-btn" href="{{ route('backend.dashboard') }}">{{ translate('My Account') }}</a>
            @else
                <a class="eg-btn btn--primary header-btn" href="{{ route('login') }}">{{ translate(get_setting('login_btn')) }}</a>
            @endif
        </div>
        <div class="mobile-menu-btn d-lg-none d-block">
            <i class='bx bx-menu'></i>
        </div>
    </div>
</header>
