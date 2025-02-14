<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo ">
        <a href="{{ url('/') }}" class="app-brand-link" target="_blank">
            {{--<span class="app-brand-logo demo">
                <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="#7367F0" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z" fill="#7367F0" />
                </svg>
            </span>--}}
            {{--<span class="app-brand-text demo menu-text fw-bold">NEXES | EMS</span>--}}
            <img src="{{ asset('apps/img/nexes_01.png') }}" alt="" class="w-px-150 d-block">
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @foreach(\App\Support\Menu::getMenuItems() as $menuItem)
            @hasanyrole($menuItem['role'])
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text" data-i18n="{{ $menuItem['header'] }}">{{ $menuItem['header'] }}</span>
                </li>
                @foreach($menuItem['menus'] as $menu)
                    @can($menu['permission'])
                        @if(isset($menu['sub']))
                            <li class="menu-item {{ (request()->is($menu['active_on'])) ? 'active open':'' }}">
                                <a @isset($menu['target']) target="{{ $menu['target'] }}" @endisset href="javascript:void(0);" class="menu-link menu-toggle">
                                    <i class='menu-icon {{ $menu['icon'] }}'></i>
                                    <div data-i18n="{{ $menu['text'] }}">{{ $menu['text'] }}</div>
                                </a>
                                <ul class="menu-sub">
                                    @foreach($menu['sub'] as $menuSub)
                                        @can($menuSub['permission'])
                                            @if(isset($menuSub['sub2']))
                                                <li class="menu-item {{ (request()->is($menuSub['active_on'])) ? 'active open':'' }}">
                                                    <a @isset($menu['target']) target="{{ $menu['target'] }}" @endisset href="javascript:void(0);" class="menu-link menu-toggle">
                                                        <div data-i18n="{{ $menuSub['text'] }}">{{ $menuSub['text'] }}</div>
                                                    </a>
                                                    <ul class="menu-sub">
                                                        @foreach($menuSub['sub2'] as $menuSubSub)
                                                            @can($menuSubSub['permission'])
                                                                @if(isset($menuSubSub['sub3']))
                                                                    <li class="menu-item {{ (request()->is($menuSubSub['active_on'])) ? 'active open':'' }}">
                                                                        <a @isset($menu['target']) target="{{ $menu['target'] }}" @endisset href="javascript:void(0);" class="menu-link menu-toggle">
                                                                            <div data-i18n="{{ $menuSubSub['text'] }}">{{ $menuSubSub['text'] }}</div>
                                                                        </a>
                                                                        <ul class="menu-sub">
                                                                            @foreach($menuSubSub['sub3'] as $menuSubSubSub)
                                                                                @can($menuSubSubSub['permission'])
                                                                                    <li class="menu-item {{ (request()->is($menuSubSubSub['active_on'])) ? 'active':'' }}">
                                                                                        <a @isset($menu['target']) target="{{ $menu['target'] }}" @endisset href="{{ $menuSubSubSub['url'] }}" class="menu-link">
                                                                                            <div data-i18n="{{ $menuSubSubSub['text'] }}">{{ $menuSubSubSub['text'] }}</div>
                                                                                        </a>
                                                                                    </li>
                                                                                @endcan
                                                                            @endforeach
                                                                        </ul>
                                                                    </li>
                                                                @else
                                                                    <li class="menu-item {{ (request()->is($menuSubSub['active_on'])) ? 'active':'' }}">
                                                                        <a @isset($menu['target']) target="{{ $menu['target'] }}" @endisset href="{{ $menuSubSub['url'] }}" class="menu-link">
                                                                            <div data-i18n="{{ $menuSubSub['text'] }}">{{ $menuSubSub['text'] }}</div>
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endcan
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li class="menu-item {{ (request()->is($menuSub['active_on'])) ? 'active':'' }}">
                                                    <a @isset($menuSub['target']) target="{{ $menuSub['target'] }}" @endisset href="{{ $menuSub['url'] }}" class="menu-link">
                                                        <div data-i18n="{{ $menuSub['text'] }}">{{ $menuSub['text'] }}</div>
                                                    </a>
                                                </li>
                                            @endif
                                        @endcan
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="menu-item {{ (request()->is($menu['active_on'])) ? 'active':'' }}">
                                <a @isset($menu['target']) target="{{ $menu['target'] }}" @endisset href="{{ $menu['url'] }}" class="menu-link">
                                    <i class="menu-icon {{ $menu['icon'] }}"></i>
                                    <div data-i18n="{{ $menu['text'] }}">{{ $menu['text'] }}</div>
                                </a>
                            </li>
                        @endif
                    @endcan
                @endforeach
            @endhasanyrole
        @endforeach
    </ul>
</aside>
<!-- / Menu -->
