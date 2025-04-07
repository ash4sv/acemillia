@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-table">
        <div class="border border-solid p-5">
            <div class="row">
                <div class="col-md-7">
                    <h3>Order ID : TXIND953621</h3>
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

                <!-- Order‑detail card -->
                <div class="order-detail-item p-3 mb-3">
                    <!-- Flex wrapper keeps all three parts in one row & equal height -->
                    <div class="d-flex align-items-stretch w-100">
                        <!-- Image column -->
                        <div class="order-item-img flex-shrink-0 me-3">
                            <img src="https://dummyimage.com/600x400/000/fff" alt="Jacket" class="img-fluid">
                        </div>

                        <!-- Description column -->
                        <div class="order-item-description flex-grow-1">
                            <p class="mb-1 text-muted">Jacket</p>
                            <h3 class="h5 mb-1">Jacket</h3>
                            <p class="mb-0 text-secondary">Color: Black&nbsp;|&nbsp;Size: XL</p>
                        </div>

                        <!-- Price / qty column -->
                        <div class="order-item-price flex-shrink-0 text-end ms-auto">
                            <p class="mb-0 fw-semibold">RM344.00 &nbsp;<span class="text-muted"> × 1</span></p>
                        </div>
                    </div>

                    <!-- Flex wrapper keeps all three parts in one row & equal height -->
                    <div class="d-flex align-items-stretch w-100">
                        <!-- Image column -->
                        <div class="order-item-img flex-shrink-0 me-3">
                            <img src="https://dummyimage.com/600x400/000/fff" alt="Jacket" class="img-fluid">
                        </div>

                        <!-- Description column -->
                        <div class="order-item-description flex-grow-1">
                            <p class="mb-1 text-muted">Jacket</p>
                            <h3 class="h5 mb-1">Jacket</h3>
                            <p class="mb-0 text-secondary">Color: Black&nbsp;|&nbsp;Size: XL</p>
                        </div>

                        <!-- Price / qty column -->
                        <div class="order-item-price flex-shrink-0 text-end ms-auto">
                            <p class="mb-0 fw-semibold">RM344.00 &nbsp;<span class="text-muted"> × 1</span></p>
                        </div>
                    </div>

                    <!-- Flex wrapper keeps all three parts in one row & equal height -->
                    <div class="d-flex align-items-stretch w-100">
                        <!-- Image column -->
                        <div class="order-item-img flex-shrink-0 me-3">
                            <img src="https://dummyimage.com/600x400/000/fff" alt="Jacket" class="img-fluid">
                        </div>

                        <!-- Description column -->
                        <div class="order-item-description flex-grow-1">
                            <p class="mb-1 text-muted">Jacket</p>
                            <h3 class="h5 mb-1">Jacket</h3>
                            <p class="mb-0 text-secondary">Color: Black&nbsp;|&nbsp;Size: XL</p>
                        </div>

                        <!-- Price / qty column -->
                        <div class="order-item-price flex-shrink-0 text-end ms-auto">
                            <p class="mb-0 fw-semibold">RM344.00 &nbsp;<span class="text-muted"> × 1</span></p>
                        </div>
                    </div>
                </div>

                <hr class="py-0">

            </div>

            {!! $order !!}
        </div>
    </div>

@endsection
