@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-table">
        <div class="border border-solid p-sm-5 p-2">
            <div class="row">
                <div class="col-md-7">
                    <h3>Order ID : TXIND953621</h3>
                </div>
                <div class="col-md-5">

                </div>
            </div>
            <div class="row g-sm-1 g-2 mb-sm-0 mb-2">

            </div>

            <div class="border border-solid p-4">
                <div class="row">
                    <div class="col-md-6 order-detail">
                        @isset($order->billingAddress)
                            @php($b = $order->billingAddress)
                            <h3 class="fw-bold">{!! __('Billing Address') !!}</h3>
                            <p class="fw-semibold">{!! $b->recipient_name !!}</p>
                            <p>{!! $b->street_address !!}, {!! $b->address !!}</p>
                            <p>{!! $b->postcode !!}, {!! $b->city !!}</p>
                            <p>{!! $b->state !!}, {!! $b->country !!}</p>
                            <p>{!! $b->phone !!}</p>
                        @endisset
                    </div>
                    <div class="col-md-6 order-detail">
                        @isset($order->shippingAddress)
                            @php($s = $order->shippingAddress)
                            <h3 class="fw-bold">{!! __('Shipping Address') !!}</h3>
                            <p class="fw-semibold">{!! $s->recipient_name !!}</p>
                            <p>{!! $s->street_address !!}, {!! $s->address !!}</p>
                            <p>{!! $s->postcode !!}, {!! $s->city !!}</p>
                            <p>{!! $s->state !!}, {!! $s->country !!}</p>
                            <p>{!! $s->phone !!}</p>
                        @endisset
                    </div>
                </div>


                <hr class="py-0">
            </div>
        </div>
    </div>

@endsection
