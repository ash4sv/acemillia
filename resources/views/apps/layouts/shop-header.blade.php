@auth('web')
    <!-- header start -->
    <header class="header-5">
        <div class="mobile-fix-option"></div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="main-menu">
                        <div class="menu-left">
                            <div class="brand-logo acemillia">
                                <a href="{{ url('/') }}">
                                    <img src="{{ asset('assets/images/logo-neuraloka_r0.png') }}" data-logo-white-mode="{{ asset('assets/images/logo-neuraloka_black.png') }}" class="img-fluid blur-up lazyload" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="menu-right pull-right">
                            <div>
                                <nav id="main-nav">
                                    <div class="toggle-nav">
                                        <i class="ri-bar-chart-horizontal-line sidebar-bar"></i>
                                    </div>
                                    <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                                        <li class="mobile-box">
                                            <div class="mobile-back text-end">Menu<i class="ri-close-line"></i></div>
                                        </li>
                                        @foreach(\App\Support\Shop::getShopItems() as $key => $item)
                                            @if($item['menu-show'])
                                                @if($item['mega-menu'])
                                                    <li class="mega hover-cls">
                                                        <a {!! $item['menu-target'] !!} href="{!! $item['menu-url'] !!}">{!! $item['menu-name'] !!}</a>
                                                        @if(count($item['menu-items']) > 0)
                                                            <ul class="mega-menu full-mega-menu">
                                                                <li>
                                                                    <div class="container">
                                                                        @foreach ($item['menu-items'] as $row)
                                                                            <div class="row g-xl-4 g-0">
                                                                                @foreach ($row as $col)
                                                                                    @if(isset($col['menu-type']) && $col['menu-type'] === 'mega-box')
                                                                                        <div class="col mega-box">
                                                                                            <div class="link-section">
                                                                                                @foreach($col['mega-menu-items'] ?? $col['menu-items'] as $menuSection)
                                                                                                    <div class="menu-section">
                                                                                                        <div class="menu-title">
                                                                                                            <h5>{!! $menuSection['menu-name'] !!}</h5>
                                                                                                        </div>
                                                                                                        @if(isset($menuSection['menu-items']) && count($menuSection['menu-items']) > 0)
                                                                                                            <div class="menu-content">
                                                                                                                <ul>
                                                                                                                    @foreach($menuSection['menu-items'] as $subMenu)
                                                                                                                        <li><a target="{{ $subMenu['menu-target'] }}" href="{!! $subMenu['menu-url'] !!}">{!! $subMenu['menu-name'] !!}</a></li>
                                                                                                                    @endforeach
                                                                                                                </ul>
                                                                                                            </div>
                                                                                                        @endif
                                                                                                    </div>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        </div>
                                                                                    @elseif (isset($col['menu-type']) && $col['menu-type'] === 'image')
                                                                                        <div class="col-12">
                                                                                            <img src="{{ asset($col['menu-name']) }}" alt="" class="img-fluid mega-img d-xl-block d-none">
                                                                                        </div>
                                                                                    @endif
                                                                                @endforeach
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @else
                                                    <li>
                                                        <a {!! $item['menu-target'] !!} href="{!! $item['menu-url'] !!}">{!! $item['menu-name'] !!}</a>
                                                        @if(count($item['menu-items']) > 0)
                                                            <ul>
                                                                @foreach($item['menu-items'] as $subItem)
                                                                    <li>
                                                                        <a {!! $subItem['menu-target'] !!} href="{!! $subItem['menu-url'] !!}">{!! $subItem['menu-name'] !!}</a>
                                                                        @if(isset($subItem['menu-sub-items']) && count($subItem['menu-sub-items']) > 0)
                                                                            <ul>
                                                                                @foreach($subItem['menu-sub-items'] as $menuSubItem)
                                                                                    <li>
                                                                                        <a target="{{ $menuSubItem['menu-sub-target'] }}" href="{!! $menuSubItem['menu-sub-url'] !!}">
                                                                                            {!! $menuSubItem['menu-sub-name'] !!}
                                                                                        </a>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endif
                                            @endif
                                        @endforeach
                                    </ul>
                                </nav>
                            </div>
                            <div class="top-header">
                                <ul class="header-dropdown">
                                    <li class="mobile-wishlist"><a href="{{ route('compare.index') }}"><i class="ri-refresh-line"></i> </a></li>
                                    <li class="mobile-wishlist"><a href="{{ route('user.wishlist.index') }}"><i class="ri-heart-line"></i> </a></li>
                                    <li class="onhover-dropdown mobile-account">
                                        <i class="ri-user-6-line"></i>
                                        <ul class="onhover-show-div">
                                            @php
                                                // Check for a user from either the 'web' guard or the 'merchant' guard
                                                $user = auth()->guard('web')->user() ?: auth()->guard('merchant')->user();
                                            @endphp

                                            @if($user)
                                                @forelse(\App\Support\LogOut::LogOut() as $logout)
                                                    {{-- Use a manual role check so that the correct dashboard/logout pair appears based on the user --}}
                                                    @if($user->hasAnyRole($logout['role']))
                                                        <li>
                                                            <a href="{{ $logout['dropdown-index']['url'] }}">
                                                                {{ __('Dashboard') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;" onclick="Apps.logoutConfirm('{{ $logout['dropdown-item']['formId'] }}')">
                                                                {{ __('Logout') }}
                                                            </a>
                                                            <form id="{{ $logout['dropdown-item']['formId'] }}" action="{{ $logout['dropdown-item']['formUrl'] }}" method="POST" class="d-none">
                                                                @csrf
                                                            </form>
                                                        </li>
                                                    @endif
                                                @empty
                                                @endforelse
                                            @else
                                                <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                                                <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                                            @endif
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <div class="icon-nav">
                                    <ul>
                                        <li class="onhover-div mobile-search">
                                            <div data-bs-toggle="modal" data-bs-target="#searchModal">
                                                <i class="ri-search-line"></i>
                                            </div>
                                        </li>
                                        <li class="onhover-div mobile-setting">
                                            <div>
                                                <i class="ri-equalizer-2-line"></i>
                                            </div>
                                            <div class="show-div setting">
                                                <h6>{!! __('language') !!}</h6>
                                                <ul>
                                                    <li><a href="#!">{!! __('english') !!}</a></li>
                                                    {{--<li><a href="#!">french</a> </li>--}}
                                                </ul>
                                                <h6>{!! __('Switch Mode') !!}</h6>
                                                <ul class="theme-switch-btn">
                                                    <li><a href="#!">{!! __('Light Mode') !!}</a></li>
                                                    <li><a href="#!">{!! __('Dark Mode') !!}</a></li>
                                                </ul>
                                                {{--<h6>currency</h6>
                                                <ul class="list-inline">
                                                    <li><a href="#!">euro</a> </li>
                                                    <li><a href="#!">rupees</a> </li>
                                                    <li><a href="#!">pound</a> </li>
                                                    <li><a href="#!">doller</a> </li>
                                                </ul>--}}
                                            </div>
                                        </li>
                                        <li class="onhover-div mobile-cart">
                                            <div data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas">
                                                <i class="ri-shopping-cart-line"></i>
                                            </div>
                                            @if(cart()->count() > 0)
                                            <span class="cart_qty_cls">{{ cart()->count() }}</span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header end -->
@endauth
