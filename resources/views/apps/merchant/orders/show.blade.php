@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-table">
        <div class="p-2">
            <div class="row">
                <div class="col-md-7">
                    <h2>Order ID : TXIND953621</h2>
                </div>
                <div class="col-md-5">

                </div>
            </div>

            <div class="border border-solid p-2">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Shipping Address</h3>
                        <p>Double crrl al</p>
                        <p>123 market street</p>
                        <p>PA 15632,|</p>
                        <p>USA</p>
                    </div>
                    <div class="col-md-6">
                        <h3>Shipping Address</h3>
                        <p>Double crrl al</p>
                        <p>123 market street</p>
                        <p>PA 15632,|</p>
                        <p>USA</p>
                    </div>
                </div>
            </div>

            {!! $order !!}
        </div>
    </div>

@endsection
