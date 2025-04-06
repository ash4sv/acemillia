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
<script>
$(document).ready(function(){
    // Fetch the state mappings once
    $.ajax({
        url: '/user/states',
        method: 'GET',
        success: function(states) {
            // Create a mapping from state code to state name
            var stateMapping = {};
            $.each(states, function(index, state) {
                stateMapping[state.value] = state.name;
            });

            // Iterate over all elements with the "state-name" class and update the text
            $('.state-name').each(function(){
                var stateCode = $(this).data('state-code');
                if(stateMapping[stateCode]) {
                    $(this).text(stateMapping[stateCode]);
                }
            });
        },
        error: function(err) {
            console.log('Error fetching state data:', err);
        }
    });

    // ========================================================

    // Get the cart count from the server-side variable
    var cartCount = {{ cart()->count() }};

    // Disable the Place Order button if there are no items in the cart
    if (cartCount === 0) {
        $('.order-btn').prop('disabled', true);
    }

    // Bind click event to the Place Order button
    $('.order-btn').on('click', function(e) {
        e.preventDefault();

        // Re-check the cart count in case it changed
        if (cartCount === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Cart is Empty',
                text: 'Please add items to your cart before proceeding.'
            });
            return;
        }

        // Validate that a shipping address is selected
        var shippingAddress = $('input[name="shippingAddress"]:checked').val();
        if (!shippingAddress) {
            Swal.fire({
                icon: 'error',
                title: 'No Shipping Address Selected',
                text: 'Please select a shipping address.'
            });
            return;
        }

        // Validate that a billing address is selected
        var billingAddress = $('input[name="billingAddress"]:checked').val();
        if (!billingAddress) {
            Swal.fire({
                icon: 'error',
                title: 'No Billing Address Selected',
                text: 'Please select a billing address.'
            });
            return;
        }

        // Get the unique identifier from the hidden input
        var uniq = $('input[name="uniq"]').val();

        // Prepare the data to be sent
        var data = {
            shippingAddress: shippingAddress,
            billingAddress: billingAddress,
            uniq: uniq
        };

        // Save the original button content for later restoration
        var $btn = $(this);
        var originalText = $btn.html();

        // Update button text to include a Bootstrap spinner and disable it
        $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...').prop('disabled', true);

        // Send AJAX POST request to the checkout route
        $.ajax({
            url: "{{ route('purchase.checkout-post') }}",
            method: 'POST',
            data: data,
            success: function(response) {
                if(response && response.success && response.redirectUrl && response.redirectUrl.trim().length > 0) {
                    window.location.href = response.redirectUrl;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Redirect URL Missing',
                        text: 'Unable to retrieve redirect URL from server.'
                    });
                    $btn.html(originalText).prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr);
                // Show SweetAlert2 error prompt
                Swal.fire({
                    icon: 'error',
                    title: 'Checkout Failed',
                    text: 'An error occurred while processing your order. Please try again.'
                });
                // Re-enable the button and restore its original text
                $btn.html(originalText).prop('disabled', false);
            },
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            }
        });
    });
});
</script>
@endpush

@section('webpage')

    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <h2>{!! __($title) !!}</h2>
            <nav class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{!! url('/') !!}">{!! __('Home') !!}</a>
                    </li>
                    @if(auth()->guard('web')->check())
                    <li class="breadcrumb-item">
                        <a href="{!! route('dashboard') !!}">{!! __('Dashboard') !!}</a>
                    </li>
                    @endif
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
                    <div id="form-checkout" class="row g-sm-4 g-3">
                        <div class="col-lg-7">
                            <div class="left-sidebar-checkout">
                                <div class="checkout-detail-box">
                                    <ul>
                                        <li>
                                            <div class="checkout-box">
                                                <div class="checkout-title">
                                                    <h4>{!! __('Shipping Address') !!}</h4>
                                                    <button data-bs-toggle="modal" data-bs-target="#basicModal" data-create-url="{{ route('user.saved-address.create') }}" data-create-title="{!! __('Address') !!}" class="d-flex align-items-center btn"><i class="ri-add-line me-1"></i> {!! __('Add New') !!}</button>
                                                </div>

                                                <div class="checkout-detail">
                                                    <div class="row g-3">
                                                        @forelse(auth()->guard('web')->user()->addressBooks as $key => $address)
                                                            <div class="col-xxl-12 col-lg-12 col-md-6">
                                                                <div class="delivery-address-box">
                                                                    <input class="form-check-input" type="radio" name="shippingAddress"
                                                                           id="{{ 'shipping-' . $address->id . '-' . $key }}"
                                                                           value="{{ $address->id }}"
                                                                           {{ $loop->first ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="{{ 'shipping-' . $address->id . '-' . $key }}">
                                                                        <span class="name">{{ __($address->title) }}</span>
                                                                        <span class="address text-content">
                                                                            <span class="text-title">{{ __('Address :') }}</span> {{ __($address->address) }}
                                                                        </span>
                                                                        <span class="address text-content">
                                                                            <span class="text-title">{{ __('Street :') }}</span> {{ __($address->street_address) }}
                                                                        </span>
                                                                        <span class="address text-content">
                                                                            <span class="text-title">{{ __('Postcode :') }}</span> {{ __($address->postcode) }}
                                                                        </span>
                                                                        <span class="address text-content">
                                                                            <span class="text-title">{{ __('City :') }}</span> {{ __($address->city) }}
                                                                        </span>
                                                                        <span class="address text-content">
                                                                            <span class="text-title">{{ __('State :') }}</span>
                                                                            <span class="state-name" data-state-code="{{ $address->state }}">
                                                                                {{ __($address->state) }}
                                                                            </span>
                                                                        </span>
                                                                        <span class="address text-content">
                                                                            <span class="text-title">{{ __('Country :') }}</span> {{ __($address->country) }}
                                                                        </span>
                                                                        <span class="address text-content">
                                                                            <span class="text-title">{{ __('Phone :') }}</span> {{ __($address->phone) }}
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="col-xxl-12 col-lg-12 col-md-12">
                                                                <div class="delivery-address-box">
                                                                    <h4 class="mb-0">{{ __('have no registered address') }}</h4>
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
                                                    <h4>{!! __('Billing Address') !!}</h4>
                                                    <button data-bs-toggle="modal" data-bs-target="#basicModal" data-create-url="{{ route('user.saved-address.create') }}" data-create-title="{!! __('Address') !!}" class="d-flex align-items-center btn"><i class="ri-add-line me-1"></i> {!! __('Add New') !!}</button>
                                                </div>

                                                <div class="checkout-detail">
                                                    <div class="row g-3">
                                                        @forelse(auth()->guard('web')->user()->addressBooks as $key => $address)
                                                        <div class="col-xxl-12 col-lg-12 col-md-6">
                                                            <div class="delivery-address-box">
                                                                <input class="form-check-input" type="radio" name="billingAddress"
                                                                       id="{!! 'billing-' . $address->id . '-' . $key !!}"
                                                                       value="{!! $address->id !!}"
                                                                        {{ $loop->first ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="{!! 'billing-' . $address->id . '-' . $key !!}">
                                                                    <span class="name">{!! __($address->title) !!}</span>
                                                                    <span class="address text-content">
                                                                        <span class="text-title">{!! __('Address :') !!}</span> {!! __($address->address) !!}
                                                                    </span>
                                                                    <span class="address text-content">
                                                                        <span class="text-title">{!! __('Street :') !!}</span> {!! __($address->street_address) !!}
                                                                    </span>
                                                                    <span class="address text-content">
                                                                        <span class="text-title">{!! __('Postcode :') !!}</span> {!! __($address->postcode) !!}
                                                                    </span>
                                                                    <span class="address text-content">
                                                                        <span class="text-title">{!! __('City :') !!}</span> {!! __($address->city) !!}
                                                                    </span>
                                                                    <span class="address text-content">
                                                                        <span class="text-title">{!! __('State :') !!}</span>
                                                                        <span class="state-name" data-state-code="{{ $address->state }}">
                                                                            {!! __($address->state) !!}
                                                                        </span>
                                                                    </span>
                                                                    <span class="address text-content">
                                                                        <span class="text-title">{!! __('Country :') !!}</span> {!! __($address->country) !!}
                                                                    </span>
                                                                    <span class="address text-content">
                                                                        <span class="text-title">{!! __('Phone :') !!}</span> {!! __($address->phone) !!}
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        @empty
                                                        <div class="col-xxl-12 col-lg-12 col-md-12">
                                                            <div class="delivery-address-box">
                                                                <h4 class="mb-0">{!! __('have no registered address') !!}</h4>
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
                                            <h4>{!! __('Summary Order') !!}</h4>
                                            <p>{!! __('For a better experience, verify your goods and choose your shipping option.') !!}</p>
                                            <input type="hidden" name="uniq" value="{!! $temporaryUniqid !!}">
                                        </div>

                                        <ul class="qty">
                                            @forelse(cart()->all() as $key => $item)
                                            <li class="align-items-start">
                                                <div class="cart-image">
                                                    <img src="{!! asset($item->options->item_img) !!}" class="img-fluid" alt="">
                                                </div>
                                                <div class="cart-content">
                                                    <div>
                                                        <h6 class="mb-1">{{ __($item->options->item_category) }}</h6>
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
                                                <p class="mb-0 pb-0">{!! __('No items in cart') !!}</p>
                                            </li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>

                                <div class="checkout-details">
                                    <div class="order-box">
                                        <div class="title-box">
                                            <h4>{!! __('Billing Summary') !!}</h4>
                                            <div class="promo-code-box">
                                                {{--<div class="promo-title">
                                                    <h5>{!! __('Promo code') !!}</h5>
                                                    <button class="btn" data-bs-toggle="modal" data-bs-target="#couponModal"><i class="ri-coupon-line"></i>{!! __('View All') !!}</button>
                                                </div>--}}
                                                {{--<div class="row g-sm-3 g-2 mb-3">
                                                    <div class="col-md-6">
                                                        <div class="coupon-box">
                                                            <div class="card-name">
                                                                <h6>{!! __('Holiday Savings') !!}</h6>
                                                            </div>
                                                            <div class="coupon-content">
                                                                <div class="coupon-apply">
                                                                    <h6 class="coupon-code success-color">{!! __('#HOLIDAY40') !!}</h6>
                                                                    <a class="btn theme-btn border-btn copy-btn mt-0" href="#!">{!! __('Copy Code') !!}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="coupon-box">
                                                            <div class="card-name">
                                                                <h6>{!! __('Holiday Savings') !!}</h6>
                                                            </div>
                                                            <div class="coupon-content">
                                                                <div class="coupon-apply">
                                                                    <h6 class="coupon-code success-color">{!! __('#HOLIDAY40') !!}</h6>
                                                                    <a class="btn theme-btn border-btn copy-btn mt-0" href="#!">{!! __('Copy Code') !!}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>--}}
                                                {{--<div class="coupon-input-box">
                                                    <input type="text" id="coupon" class="form-control" placeholder="Enter Coupon Code Here...">
                                                    <button class="apply-button btn">{!! __('Apply now') !!}</button>
                                                </div>--}}
                                            </div>
                                        </div>
                                        <div class="custom-box-loader">
                                            <ul class="sub-total">
                                                <li>{!! __('Sub Total') !!} <span class="count">{{ __('MYR' . number_format(cart()->subtotal(), 2)) }}</span></li>
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
                                            <li>{!! __('Total') !!} <span class="count">{{ __('MYR' . number_format(cart()->total(), 2)) }}</span></li>
                                        </ul>
                                        <div class="text-end">
                                            <button class="btn order-btn">{!! __('Place Order') !!}</button>
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
