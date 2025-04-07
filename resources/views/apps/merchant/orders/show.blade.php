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
                        @isset($subOrder->order->billing_address)
                            @php($b = $subOrder->order->billing_address)
                            <h3 class="h6 fw-bold mb-2">{!! __('Billing Address') !!}</h3>
                            <p class="mb-1 fw-semibold">{!! $b->recipient_name !!}</p>
                            <p class="mb-1">
                                {!! $b->street_address !!}, {!! $b->address !!}
                            </p>
                            <p class="mb-1">
                                {!! $b->postcode !!}, {!! $b->city !!}
                            </p>
                            <p class="mb-1">
                                {!! $b->state !!}, {!! $b->country !!}
                            </p>
                            <p class="mb-0">
                                <span class="text-muted">☎</span> {!! $b->phone !!}
                            </p>
                        @endisset
                    </div>
                    <div class="col-md-6 order-detail">
                        @isset($subOrder->order->shipping_address)
                            @php($s = $subOrder->order->shipping_address)
                            <h3 class="h6 fw-bold mb-2">{!! __('Shipping Address') !!}</h3>
                            <p class="mb-1 fw-semibold">{!! $s->recipient_name !!}</p>
                            <p class="mb-1">
                                {!! $s->street_address !!}, {!! $s->address !!}
                            </p>
                            <p class="mb-1">
                                {!! $s->postcode !!}, {!! $s->city !!}
                            </p>
                            <p class="mb-1">
                                {!! $s->state !!}, {!! $s->country !!}
                            </p>
                            <p class="mb-0">
                                <span class="text-muted">☎</span> {!! $s->phone !!}
                            </p>
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
