@extends('apps.layouts.shop')

@php
    $title = 'Checkout';
    $description = '';
    $keywords = '';
    $author = '';
@endphp

@section('description', '')
@section('keywords', '')
@section('author', '')
@section('title', $title)

@push('style')

@endpush

@push('script')

@endpush

@section('webpage')

    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <h2>{!! $title !!}</h2>
            <nav class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{!! url('/') !!}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">{!! __($title) !!}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb End -->

    <!-- section start -->
    <section class="section-b-space checkout-section-2">
        <div class="container">
            <div class="checkout-page">
                <div class="checkout-form">
                    <div class="row g-sm-4 g-3">
                        <div class="col-lg-7">
                            <div class="left-sidebar-checkout">
                                <div class="checkout-detail-box">
                                    <ul>
                                        <li>
                                            <div class="checkout-box">
                                                <div class="checkout-title">
                                                    <h4>Shipping Address</h4>
                                                    <button data-bs-toggle="modal" data-bs-target="#basicModal" data-create-url="{{ route('user.saved-address.create') }}" data-create-title="Address" class="d-flex align-items-center btn"><i class="ri-add-line me-1"></i> Add New</button>
                                                </div>

                                                <div class="checkout-detail">
                                                    <div class="row g-3">
                                                        @forelse(auth()->guard('web')->user()->addressBooks as $key => $address)
                                                        <div class="col-xxl-6 col-lg-12 col-md-6">
                                                            <div class="delivery-address-box">
                                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="check" checked>
                                                                <label class="form-check-label" for="check">
                                                                    <span class="name">New Home</span>
                                                                    <span class="address text-content"><span class="text-title">Address :</span> 26, Starts Hollow Colony, Denver, Colorado, United States</span>
                                                                    <span class="address text-content"><span class="text-title">Pin Code :</span> 80014</span>
                                                                    <span class="address text-content"><span class="text-title">Phone :</span> +1 5551855359</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        @empty
                                                        <div class="col-xxl-12 col-lg-12 col-md-12">
                                                            <div class="delivery-address-box">
                                                                <h4 class="mb-0">have no registered address</h4>
                                                            </div>
                                                        </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="checkout-box">
                                                <div class="checkout-title">
                                                    <h4>Billing Address</h4>
                                                    <button data-bs-toggle="modal" data-bs-target="#basicModal" data-create-url="{{ route('user.saved-address.create') }}" data-create-title="Address" class="d-flex align-items-center btn"><i class="ri-add-line me-1"></i> Add New</button>
                                                </div>

                                                <div class="checkout-detail">
                                                    <div class="row g-3">
                                                        @forelse(auth()->guard('web')->user()->addressBooks as $key => $address)
                                                        <div class="col-xxl-6 col-lg-12 col-md-6">
                                                            <div class="delivery-address-box">
                                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="check" checked>
                                                                <label class="form-check-label" for="check">
                                                                    <span class="name">New Home</span>
                                                                    <span class="address text-content"><span class="text-title">Address :</span> 26, Starts Hollow Colony, Denver, Colorado, United States</span>
                                                                    <span class="address text-content"><span class="text-title">Pin Code :</span> 80014</span>
                                                                    <span class="address text-content"><span class="text-title">Phone :</span> +1 5551855359</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        @empty
                                                        <div class="col-xxl-12 col-lg-12 col-md-12">
                                                            <div class="delivery-address-box">
                                                                <h4 class="mb-0">have no registered address</h4>
                                                            </div>
                                                        </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                        {{--<li>
                                            <div class="checkout-box">
                                                <div class="checkout-title">
                                                    <h4>Delivery Options</h4>
                                                </div>

                                                <div class="checkout-detail">
                                                    <div class="row g-3">
                                                        <div class="col-xxl-6 col-lg-12 col-md-6">
                                                            <div class="delivery-address-box">
                                                                <input class="form-check-input" type="radio" name="checkbox2" id="check7">
                                                                <label class="form-check-label" for="check7">Standard Delivery | Approx 5 to 7 Days</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-xxl-6 col-lg-12 col-md-6">
                                                            <div class="delivery-address-box">
                                                                <input class="form-check-input" type="radio" name="checkbox2" id="check8" checked>
                                                                <label class="form-check-label" for="check8">Express Delivery | Schedule </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>--}}

                                        {{--<li>
                                            <div class="checkout-box">
                                                <div class="checkout-title">
                                                    <h4>Payment Options</h4>
                                                </div>
                                                <div class="checkout-detail">
                                                    <div class="row g-3">
                                                        <div class="col-sm-6">
                                                            <div class="delivery-address-box">
                                                                <input class="form-check-input" type="radio" name="checkbox3" id="check9">
                                                                <label class="form-check-label" for="check9">CASH ON DELIVERY</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="delivery-address-box">
                                                                <input class="form-check-input" type="radio" name="checkbox3" id="check10" checked>
                                                                <label class="form-check-label" for="check10">PAYPAL</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="delivery-address-box">
                                                                <input class="form-check-input" type="radio" name="checkbox3" id="check11" checked>
                                                                <label class="form-check-label" for="check11">STRIPE</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="delivery-address-box">
                                                                <input class="form-check-input" type="radio" name="checkbox3" id="check12" checked>
                                                                <label class="form-check-label" for="check12">SSLCOMMERZ</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="delivery-address-box">
                                                                <input class="form-check-input" type="radio" name="checkbox3" id="check13" checked>
                                                                <label class="form-check-label" for="check13">FLUTTERWAVE</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="delivery-address-box">
                                                                <input class="form-check-input" type="radio" name="checkbox3" id="check14" checked>
                                                                <label class="form-check-label" for="check14">PAYSTACK</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="delivery-address-box">
                                                                <input class="form-check-input" type="radio" name="checkbox3" id="check15" checked>
                                                                <label class="form-check-label" for="check15">MOLLIE</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="delivery-address-box">
                                                                <input class="form-check-input" type="radio" name="checkbox3" id="check16" checked>
                                                                <label class="form-check-label" for="check16">BANK TRANSFER</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="delivery-address-box">
                                                                <input class="form-check-input" type="radio" name="checkbox3" id="check17" checked>
                                                                <label class="form-check-label" for="check17">BKASH</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="delivery-address-box">
                                                                <input class="form-check-input" type="radio" name="checkbox3" id="check18" checked>
                                                                <label class="form-check-label" for="check18">CCAVENUE</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="delivery-address-box">
                                                                <input class="form-check-input" type="radio" name="checkbox3" id="check19" checked>
                                                                <label class="form-check-label" for="check19">PHONEPE</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="delivery-address-box">
                                                                <input class="form-check-input" type="radio" name="checkbox3" id="20" checked>
                                                                <label class="form-check-label" for="20">INSTAMOJO</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>--}}
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="checkout-right-box">
                                <div class="checkout-details">
                                    <div class="order-box">
                                        <div class="title-box">
                                            <h4>Summary Order</h4>
                                            <p>For a better experience, verify your goods and choose your shipping option.</p>
                                        </div>

                                        <ul class="qty">
                                            @forelse(cart()->all() as $key => $item)
                                            <li class="align-items-start">
                                                <div class="cart-image">
                                                    <img src="{!! asset($item->options->item_img) !!}" class="img-fluid" alt="">
                                                </div>
                                                <div class="cart-content">
                                                    <div>
                                                        <h4>{{ __($item->name) }}</h4>
                                                        <h5 class="mb-1">{{ __('MYR' . number_format($item->price, 2)) . ' x ' . __($item->quantity) }}</h5>
                                                        @if(isset($item->options->option_groups) && is_array($item->options->option_groups))
                                                            @foreach($item->options->option_groups as $groupKey => $group)
                                                                @foreach($group->options as $option)
                                                                    <p class="mb-1"><strong>{{ $option->option_name }}:</strong> {{ $option->value_name }}</p>
                                                                @endforeach
                                                                @isset($group->quantity)
                                                                <p class="mb-1"><strong>Quantity:</strong> {{ $group->quantity }}</p>
                                                                @endisset
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <span class="text-theme">{{ __('MYR' . number_format($item->price * $item->quantity, 2)) }}</span>
                                                </div>
                                            </li>
                                            @empty
                                            <li>
                                                <p class="mb-0 pb-0">No items in cart</p>
                                            </li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>

                                <div class="checkout-details">
                                    <div class="order-box">
                                        <div class="title-box">
                                            <h4>Billing Summary</h4>
                                            <div class="promo-code-box">
                                                <div class="promo-title">
                                                    <h5>Promo code</h5>
                                                    <button class="btn" data-bs-toggle="modal" data-bs-target="#couponModal"><i class="ri-coupon-line"></i>View All</button>
                                                </div>
                                                <div class="row g-sm-3 g-2 mb-3">
                                                    <div class="col-md-6">
                                                        <div class="coupon-box">
                                                            <div class="card-name">
                                                                <h6>Holiday Savings</h6>
                                                            </div>
                                                            <div class="coupon-content">
                                                                <div class="coupon-apply">
                                                                    <h6 class="coupon-code success-color">#HOLIDAY40</h6>
                                                                    <a class="btn theme-btn border-btn copy-btn mt-0" href="#!">Copy Code</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="coupon-box">
                                                            <div class="card-name">
                                                                <h6>Holiday Savings</h6>
                                                            </div>
                                                            <div class="coupon-content">
                                                                <div class="coupon-apply">
                                                                    <h6 class="coupon-code success-color">#HOLIDAY40</h6>
                                                                    <a class="btn theme-btn border-btn copy-btn mt-0" href="#!">Copy Code</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="coupon-input-box">
                                                    <input type="text" id="coupon" class="form-control" placeholder="Enter Coupon Code Here...">
                                                    <button class="apply-button btn">Apply now</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="custom-box-loader">
                                            <ul class="sub-total">
                                                <li>Sub Total <span class="count">{{ __('MYR' . number_format(cart()->subtotal(), 2)) }}</span></li>
                                                {{--<li>Shipping <span class="count">$0.00</span></li>--}}
                                                {{--<li>Tax <span class="count">$1.46</span></li>--}}
                                                {{--<li>
                                                    <h4 class="txt-muted">Points</h4>
                                                    <h4 class="price txt-muted">$65.66</h4>
                                                </li>--}}
                                                {{--<li class="border-cls">
                                                    <label for="ponts" class="form-check-label m-0">Would you prefer to pay using points?</label>
                                                    <input type="checkbox" id="ponts" class="checkbox_animated check-it">
                                                </li>--}}
                                                {{--<li>
                                                    <h4>Wallet Balance</h4>
                                                    <h4 class="price">$8.47</h4>
                                                </li>--}}
                                                {{--<li class="border-cls">
                                                    <label for="wallet" class="form-check-label m-0">Would you prefer to pay using wallet?</label>
                                                    <input type="checkbox" id="wallet" class="checkbox_animated check-it">
                                                </li>--}}
                                            </ul>
                                        </div>
                                        <ul class="total">
                                            <li>Total <span class="count">{{ __('MYR' . number_format(cart()->total(), 2)) }}</span></li>
                                        </ul>
                                        <div class="text-end">
                                            <button class="btn order-btn">Place Order</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section end -->

@endsection
