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
                    @forelse($subOrder->items as $i => $item)
                    <div class="order-itemize d-flex align-items-stretch w-100">
                        <div class="order-item-img flex-shrink-0 me-3">
                            <img src="https://dummyimage.com/600x400/000/fff" alt="Jacket" class="img-fluid">
                        </div>

                        <div class="order-item-description flex-grow-1">
                            <p class="mb-1 text-muted">Jacket</p>
                            <h3 class="h5 fw-medium mb-1">{!! $item->product_name !!}</h3>
                            <p class="mb-0 text-secondary">Color: Black&nbsp;|&nbsp;Size: XL</p>
                        </div>

                        <div class="order-item-price flex-shrink-0 text-end ms-auto">
                            <p class="mb-0">{!! 'RM' . number_format($item->price, 2) !!} &nbsp;<span class="text-muted"> × {!! $item->quantity !!}</span></p>
                        </div>
                    </div>
                    @empty
                    <div class="order-itemize d-flex align-items-stretch w-100">

                    </div>
                    @endforelse
                </div>

                <hr class="py-0 mt-0">

            </div>

            {!! $subOrder !!}
        </div>
    </div>

@endsection
