@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-table">
        <div class="border border-solid p-5">
            <div class="row">
                <div class="col-md-7">
                    <h2>Order ID : TXIND953621</h2>
                </div>
                <div class="col-md-5">

                </div>
            </div>

            <div class="border border-solid p-4">
                <div class="row">
                    <div class="col-md-6 order-detail">
                        <h3>Shipping Address</h3>
                        <p>Double crrl al</p>
                        <p>123 market street</p>
                        <p>PA 15632,|</p>
                        <p>USA</p>
                    </div>
                    <div class="col-md-6 order-detail">
                        <h3>Shipping Address</h3>
                        <p>Double crrl al</p>
                        <p>123 market street</p>
                        <p>PA 15632,|</p>
                        <p>USA</p>
                    </div>
                </div>

                <hr class="py-0">

                <div class="order-detail-item">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="order-item-img">
                                <div class="">
                                    <img src="" alt="" class="img-fluid">
                                </div>
                            </div>
                            <div class="order-item-description">
                                <p>Jacket</p>
                                <h3>Jacket</h3>
                                <p>Color: Black | Size: XL</p>
                            </div>
                            <div class="order-item-price">
                                <p>RM344.00 x 1</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {!! $order !!}
        </div>
    </div>

@endsection
