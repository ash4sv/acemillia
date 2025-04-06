@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-table">
        <div class="wallet-table">
            <div class="top-sec">
                <h3>{!! __('Order') !!}</h3>
                {{--<a href="#!" class="btn btn-sm btn-solid">add product</a>--}}
            </div>
            <div>
                <div class="card p-2">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold">Order number</h6>
                                <h5 class="fw-light">T425858300</h5>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold">Order placed</h5>
                                <h6 class="fw-light">November 27, 2023</h6>
                            </div>
                        </div>
                        <hr class="py-0">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold">Delivery address</h6>
                                John Newman
                                USA
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold">Billing address</h6>
                                John Newman
                                USA
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold">Payment</h6>


                                <h6 class="fw-bold">Shipping</h6>
                                Standard shipping
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold">Order summary</h6>
                                Subtotal $5.99 <br>
                                Delivery $4.95 <br>
                                Tax $0.36 <br>
                                Total $11.30 <br>
                            </div>
                        </div>

                    </div>
                </div>
                {!! $order !!}
            </div>
        </div>
    </div>

@endsection
