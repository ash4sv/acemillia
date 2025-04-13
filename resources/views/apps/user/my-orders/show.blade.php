@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-table">
        <div class="border border-solid p-sm-5 p-2">
            <div class="row">
                <div class="col-md-7">
                    <h3>Order ID : TXIND953621</h3>
                </div>
                <div class="col-md-5">
                    <!-- (Optional extra content) -->
                </div>
            </div>

            <div class="border border-solid p-4">
                <div class="row">
                    <!-- Billing Address -->
                    <div class="col-md-6 order-detail">
                        @if(isset($order->billingAddress))
                            @php($b = $order->billingAddress)
                            <h3 class="fw-bold">{{ __('Billing Address') }}</h3>
                            <p class="fw-semibold">{{ $b->recipient_name }}</p>
                            <p>{{ $b->street_address }}, {{ $b->address }}</p>
                            <p>{{ $b->postcode }}, {{ $b->city }}</p>
                            <p>{{ $b->state }}, {{ $b->country }}</p>
                            <p>{{ $b->phone }}</p>
                        @else

                        @endif
                    </div>
                    <!-- Shipping Address -->
                    <div class="col-md-6 order-detail">
                        @if(isset($order->shippingAddress))
                            @php($s = $order->shippingAddress)
                            <h3 class="fw-bold">{{ __('Shipping Address') }}</h3>
                            <p class="fw-semibold">{{ $s->recipient_name }}</p>
                            <p>{{ $s->street_address }}, {{ $s->address }}</p>
                            <p>{{ $s->postcode }}, {{ $s->city }}</p>
                            <p>{{ $s->state }}, {{ $s->country }}</p>
                            <p>{{ $s->phone }}</p>
                        @else

                        @endif
                    </div>
                </div>
            </div>

            {{-- Loop through each suborder and display order tracking information --}}
            {{--@foreach($order->subOrders as $subOrder)--}}
                {{--<div class="row g-sm-1 g-2 mb-sm-0 mb-2">
                    <!-- Order Made Card -->
                    <div class="col-md-3 col-12">
                        <div class="card my-sm-3 my-0">
                            <div class="card-body p-2 border border-light">
                                <div class="d-flex flex-column flex-md-row align-items-stretch">
                                    <div class="box-custom-container flex-shrink-0 align-content-center">
                                        <i class="ri-home-line bg-pending"></i>
                                    </div>
                                    <div class="box-custom-container flex-grow-1 align-content-center mx-2">
                                        <p class="fw-bold mb-1">Order made</p>
                                        <p class="small fw-light mb-0">Create order</p>
                                    </div>
                                    <div class="box-custom-container flex-shrink-0 align-content-center">
                                        <!-- (Optional extra content) -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status Card -->
                    <div class="col-md-3 col-12">
                        <div class="card my-sm-3 my-0">
                            @php
                                $paymentStatus = $order->payment_status;
                                $paymentStatusClassMap = [
                                    'pending' => 'bg-pending',
                                    'paid'    => 'bg-credit',
                                    'failed'  => 'bg-debit',
                                ];
                                $paymentStatusClass = $paymentStatusClassMap[$paymentStatus] ?? 'bg-default';
                                $paymentStatusLabel = ucfirst($paymentStatus);

                                $paymentBorderColors = [
                                    'pending' => 'border-light',
                                    'paid'    => 'border-success',
                                    'failed'  => 'border-danger',
                                ];
                                $paymentIconLabels = [
                                    'pending' => 'ri-loader-3-line',
                                    'paid'    => 'ri-check-line',
                                    'failed'  => 'ri-close-large-line',
                                ];

                                $paymentBorderColor = $paymentBorderColors[$paymentStatus] ?? 'border-light';
                                $paymentIconLabel   = $paymentIconLabels[$paymentStatus] ?? 'icon-default';
                            @endphp
                            <div class="card-body p-2 border {{ $paymentBorderColor }}">
                                <div class="d-flex flex-column flex-md-row align-items-stretch">
                                    <div class="box-custom-container flex-shrink-0 align-content-center text-sm-start">
                                        <i class="{{ $paymentIconLabel }} {{ $paymentStatusClass }}"></i>
                                    </div>
                                    <div class="box-custom-container flex-grow-1 align-content-center mx-2 text-sm-start">
                                        <p class="fw-bold mb-1">{{ $paymentStatusLabel }}</p>
                                        <p class="small fw-light mb-0">{{ $paymentStatusLabel }}s</p>
                                    </div>
                                    <div class="box-custom-container flex-shrink-0 align-content-center text-sm-start">
                                        <!-- (Optional extra content) -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Status Card -->
                    <div class="col-md-3 col-12">
                        <div class="card my-sm-3 my-0">
                            @php
                                $shippingStatus = $subOrder->shipping_status;
                                $shippingStatusClassMap = [
                                    'pending'   => 'bg-pending',
                                    'shipped'   => 'bg-credit',
                                    'delivered' => 'bg-completed',
                                    'cancelled' => 'bg-debit',
                                ];
                                $shippingStatusClass = $shippingStatusClassMap[$shippingStatus] ?? 'bg-default';
                                $shippingStatusLabel = ucfirst($shippingStatus);

                                $shippingStatusSubLabels = [
                                    'pending'   => 'Awaiting Shipment',
                                    'shipped'   => 'On the Way',
                                    'delivered' => 'Delivered Successfully',
                                    'cancelled' => 'Shipment Cancelled',
                                ];
                                $shippingBorderColors = [
                                    'pending'   => 'border-light',
                                    'shipped'   => 'border-primary',
                                    'delivered' => 'border-success',
                                    'cancelled' => 'border-danger',
                                ];
                                $shippingIconLabels = [
                                    'pending'   => 'ri-list-check-3',
                                    'shipped'   => 'ri-truck-line',
                                    'delivered' => 'ri-check-line',
                                    'cancelled' => 'ri-close-large-line',
                                ];

                                $shippingStatusSubLabel = $shippingStatusSubLabels[$shippingStatus] ?? 'Status Unknown';
                                $shippingBorderColor    = $shippingBorderColors[$shippingStatus] ?? 'border-light';
                                $shippingIconLabel      = $shippingIconLabels[$shippingStatus] ?? 'icon-default';
                            @endphp
                            <div class="card-body p-2 border {{ $shippingBorderColor }}">
                                <div class="d-flex flex-column flex-md-row align-items-stretch">
                                    <div class="box-custom-container flex-shrink-0 align-content-center">
                                        <i class="{{ $shippingIconLabel }} {{ $shippingStatusClass }}"></i>
                                    </div>
                                    <div class="box-custom-container flex-grow-1 align-content-center mx-2">
                                        <p class="fw-bold mb-1">{{ $shippingStatusLabel }}</p>
                                        <p class="small fw-light mb-0">{{ $shippingStatusSubLabel }}</p>
                                    </div>
                                    <div class="box-custom-container flex-shrink-0 align-content-center">
                                        <!-- (Optional extra content) -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Completion Card -->
                    <div class="col-md-3 col-12">
                        <div class="card my-sm-3 my-0">
                            @php
                                $orderComplete = ($order->payment_status === 'paid' && $subOrder->shipping_status === 'delivered');
                                $cardStatus  = $orderComplete ? 'Complete' : 'In Progress';
                                $cardMessage = $orderComplete ? 'Order completed' : 'Order in progress';

                                $cardIconLabels = [
                                    'Complete'    => 'ri-check-double-line',
                                    'In Progress' => 'ri-progress-5-line',
                                ];

                                $orderBorderColors = [
                                    'Complete'    => 'border-success',
                                    'In Progress' => 'border-light',
                                ];

                                $cardIconClassMapping = [
                                    'Complete'    => 'bg-completed',
                                    'In Progress' => 'bg-pending',
                                ];

                                $orderIconLabel = $cardIconLabels[$cardStatus] ?? 'icon-default';
                                $orderBorderColor = $orderBorderColors[$cardStatus] ?? 'border-light';
                                $cardIconClass = $cardIconClassMapping[$cardStatus] ?? 'bg-default';
                            @endphp
                            <div class="card-body p-2 border {{ $orderBorderColor }}">
                                <div class="d-flex flex-column flex-md-row align-items-stretch">
                                    <div class="box-custom-container flex-shrink-0 align-content-center">
                                        <i class="{{ $orderIconLabel }} {{ $cardIconClass }}"></i>
                                    </div>
                                    <div class="box-custom-container flex-grow-1 align-content-center mx-2">
                                        <p class="fw-bold mb-1">{{ $cardStatus }}</p>
                                        <p class="small fw-light mb-0">{{ $cardMessage }}</p>
                                    </div>
                                    <div class="box-custom-container flex-shrink-0 align-content-center">
                                        <!-- (Optional extra content) -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                --}}{{-- Display items for this suborder --}}{{--
                <div class="border border-solid p-4">
                    <hr class="py-0">
                    <div class="order-detail-item p-3 mb-3">
                        --}}{{--@foreach($subOrder->items as $item)
                            <div class="order-itemize d-flex align-items-stretch w-100">
                                <div class="order-item-img flex-shrink-0 me-3">
                                    <img src="https://dummyimage.com/600x400/000/fff" alt="Jacket" class="img-fluid">
                                </div>
                                <div class="order-item-description flex-grow-1">
                                    <p class="mb-1 text-muted">Jacket</p>
                                    <h3 class="h5 fw-medium mb-1">{{ $item->product_name }}</h3>
                                    <p class="mb-0 text-secondary">Color: Black&nbsp;|&nbsp;Size: XL</p>
                                </div>
                                <div class="order-item-price flex-shrink-0 text-end ms-auto">
                                    <p class="mb-0">RM{{ number_format($item->price, 2) }} &nbsp;<span class="text-muted">× {{ $item->quantity }}</span></p>
                                </div>
                            </div>
                        @endforeach--}}{{--
                    </div>
                    <hr class="py-0 mt-0">
                    <h4 class="mb-4">Order Summary</h4>
                    <div class="single-cart-item d-flex align-items-stretch">
                        <div class="box flex-shrink-0">
                            <h4 class="fw-medium">Total Sales</h4>
                        </div>
                        <div class="box flex-grow-1">
                            <!-- (Optional extra content) -->
                        </div>
                        <div class="box flex-shrink-0 text-end">
                            <h4 class="fw-medium">{{ $order->total_amount }}</h4>
                        </div>
                    </div>
                </div>--}}
            {{--@endforeach--}}
        </div>
    </div>

@endsection
