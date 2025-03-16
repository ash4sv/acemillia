<ul class="nav nav-tabs" id="top-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" href="{!! route('merchant.dashboard') !!}">
            <i class="ri-home-line"></i> {!! __('Dashboard') !!}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="ri-product-hunt-line"></i> {!! __('Products') !!}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="ri-file-text-line"></i> {!! __('Orders') !!}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="ri-user-3-line"></i> {!! __('Profile') !!}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="ri-settings-line"></i> {!! __('Settings') !!}
        </a>
    </li>
    @forelse(\App\Support\LogOut::LogOut() as $key => $logout)
        @hasanyrole($logout['role'])
        <li class="nav-item logout-cls">
            <a href="javascript:;" onclick="Apps.logoutConfirm('{!! $logout['dropdown-item']['formId'] !!}')" class="btn loagout-btn">
                <i class="ri-logout-box-r-line"></i> {!! __('Logout') !!}
            </a>
            <form id="{!! $logout['dropdown-item']['formId'] !!}" action="{!! $logout['dropdown-item']['formUrl'] !!}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
        @endhasanyrole
    @empty

    @endforelse
</ul>
