<ul id="pills-tab" role="tablist" class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link {{ request('section') == null ? 'active' : '' }}" id="info-tab" href="{{ route('dashboard') }}">
            <i class="ri-home-line"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('section') == 'notifications' ? 'active' : '' }}" id="notification-tab" href="{{ route('dashboard', ['section' => 'notifications']) }}">
            <i class="ri-notification-line"></i> Notifications
        </a>
    </li>
    {{--<li role="presentation" class="nav-item">
        <button class="nav-link" id="bank-details-tab" data-bs-toggle="tab" data-bs-target="#bank-details-tab-pane" type="button" role="tab">
            <i class="ri-bank-line"></i> Bank Details
        </button>
    </li>--}}
    {{--<li role="presentation" class="nav-item">
        <button class="nav-link" id="wallet-tab" data-bs-toggle="tab" data-bs-target="#wallet-tab-pane" type="button" role="tab">
            <i class="ri-wallet-line"></i> My Wallet
        </button>
    </li>--}}
    {{--<li role="presentation" class="nav-item">
        <button class="nav-link" id="earning" data-bs-toggle="tab" data-bs-target="#earning-tab-pane" type="button" role="tab">
            <i class="ri-coin-line"></i> Earning Points
        </button>
    </li>--}}
    <li class="nav-item">
        <a class="nav-link {{ request('section') == 'my-order' ? 'active' : '' }}" id="order-tab" href="{{ route('dashboard', ['section' => 'my-order']) }}">
            <i class="ri-file-text-line"></i>My Orders
        </a>
    </li>
    {{--<li role="presentation" class="nav-item">
        <button class="nav-link" id="refund-tab" data-bs-toggle="tab" data-bs-target="#refund-tab-pane" type="button" role="tab">
            <i class="ri-money-dollar-circle-line"></i> Refund History
        </button>
    </li>--}}
    <li class="nav-item">
        <a class="nav-link {{ request('section') == 'saved-address' ? 'active' : '' }}" id="address" href="{{ route('dashboard', ['section' => 'saved-address']) }}">
            <i class="ri-map-pin-line"></i> Saved Address
        </a>
    </li>
    @forelse(\App\Support\LogOut::LogOut() as $key => $logout)
        @if(Auth::guard('web')->check() && Auth::guard('web')->user()->hasAnyRole($logout['role']))
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
        <!-- Optionally handle if no logout items are returned -->
    @endforelse
</ul>
