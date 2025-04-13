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
            <div class="row g-1">
                <div class="col-md-4 col-12">
                    <div class="card my-3">
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

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="card my-3">
                        <div class="card-body p-2 border border-light">
                            <div class="d-flex flex-column flex-md-row align-items-stretch">
                                <div class="box-custom-container flex-shrink-0 align-content-center">
                                    <i class="ri-home-line bg-pending"></i>
                                </div>
                                <div class="box-custom-container flex-grow-1 align-content-center mx-2">
                                    <p class="fw-bold mb-1">Order paid</p>
                                    <p class="small fw-light mb-0">Customer payment</p>
                                </div>
                                <div class="box-custom-container flex-shrink-0 align-content-center">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="card my-3">
                        <div class="card-body p-2 border border-light">
                            <div class="d-flex flex-column flex-md-row align-items-stretch">
                                <div class="box-custom-container flex-shrink-0 align-content-center">
                                    <i class="ri-home-line bg-pending"></i>
                                </div>
                                <div class="box-custom-container flex-grow-1 align-content-center mx-2">
                                    <p class="fw-bold mb-1">Shipped Complete</p>
                                    <p class="small fw-light mb-0">On delivery</p>
                                </div>
                                <div class="box-custom-container flex-shrink-0 align-content-center">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="card my-3">
                        <div class="card-body p-2 border border-light">
                            <div class="d-flex flex-column flex-md-row align-items-stretch">
                                <div class="box-custom-container flex-shrink-0 align-content-center">
                                    <i class="ri-home-line bg-pending"></i>
                                </div>
                                <div class="box-custom-container flex-grow-1 align-content-center mx-2">
                                    <p class="fw-bold mb-1">Complete</p>
                                    <p class="small fw-light mb-0">Order completed</p>
                                </div>
                                <div class="box-custom-container flex-shrink-0 align-content-center">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border border-solid p-4">
                <div class="row">
                    <div class="col-md-6 order-detail">
                        @isset($subOrder->order->billingAddress)
                            @php($b = $subOrder->order?->billingAddress)
                            <h3 class="fw-bold">{!! __('Billing Address') !!}</h3>
                            <p class="fw-semibold">{!! $b->recipient_name !!}</p>
                            <p>{!! $b->street_address !!}, {!! $b->address !!}</p>
                            <p>{!! $b->postcode !!}, {!! $b->city !!}</p>
                            <p>{!! $b->state !!}, {!! $b->country !!}</p>
                            <p>{!! $b->phone !!}</p>
                        @endisset
                    </div>
                    <div class="col-md-6 order-detail">
                        @isset($subOrder->order->shippingAddress)
                            @php($s = $subOrder->order?->shippingAddress)
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
                        <div class="flex-grow-1 text-center py-5">
                            <h3 class="m-0 text-center">
                                No valid items found for this order — they may have been removed or never existed.
                            </h3>
                        </div>
                    </div>
                    @endforelse
                </div>

                <hr class="py-0 mt-0">

            </div>

            {!! $subOrder !!}
        </div>
    </div>

@endsection
