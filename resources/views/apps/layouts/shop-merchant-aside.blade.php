<ul class="nav nav-tabs" id="top-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link {{ request('section') == null ? 'active' : '' }}" href="{!! route('merchant.dashboard') !!}">
            <i class="ri-home-line"></i> {!! __('Dashboard') !!}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ in_array(request('section'), ['news-feed']) ? 'active' : '' }}" href="{{ route('merchant.dashboard', ['section' => 'news-feed']) }}">
            <i class="ri-news-line"></i> {!! __('News Feed') !!}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ in_array(request('section'), ['products', 'product-create']) ? 'active' : '' }}" href="{{ route('merchant.dashboard', ['section' => 'products']) }}">
            <i class="ri-product-hunt-line"></i> {{ __('Products') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {!! in_array(request('section'), ['orders', 'order-show']) ? 'active' : '' !!}" href="{!! route('merchant.dashboard', ['section' => 'orders']) !!}">
            <i class="ri-file-text-line"></i> {!! __('Orders') !!}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {!! in_array(request('section'), ['profile', 'profile-edit', 'password-edit']) ? 'active' : '' !!}" href="{!! route('merchant.dashboard', ['section' => 'profile']) !!}">
            <i class="ri-user-3-line"></i> {!! __('Profile') !!}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {!! request('section') == 'settings' ? 'active' : '' !!}" href="{!! route('merchant.dashboard', ['section' => 'settings']) !!}">
            <i class="ri-settings-line"></i> {!! __('Settings') !!}
        </a>
    </li>
    @forelse(\App\Support\LogOut::LogOut() as $key => $logout)
        @if(Auth::guard('merchant')->check() && Auth::guard('merchant')->user()->hasAnyRole($logout['role']))
            <li class="nav-item logout-cls">
                <a href="javascript:;" onclick="Apps.logoutConfirm('{{ $logout['dropdown-item']['formId'] }}')" class="btn loagout-btn">
                    <i class="ri-logout-box-r-line"></i> {{ __('Logout') }}
                </a>
                <form id="{{ $logout['dropdown-item']['formId'] }}" action="{{ $logout['dropdown-item']['formUrl'] }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        @endif
    @empty
    @endforelse

</ul>
