@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="counter-section">
        <div class="row">
            <div class="col-md-4">
                <div class="counter-box">
                    <img src="{!! asset('assets/images/icon/dashboard/order.png') !!}" alt="" class="img-fluid">
                    <div>
                        <h3>{!! $products->count() !!}</h3>
                        <h5>total products</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="counter-box">
                    <img src="{!! asset('assets/images/icon/dashboard/sale.png') !!}" alt="" class="img-fluid">
                    <div>
                        <h3>RM{{ number_format($authUser->wallet->balance, 2) }}</h3>
                        <h5>Wallet Balance</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="counter-box">
                    <img src="{!! asset('assets/images/icon/dashboard/homework.png') !!}" alt="" class="img-fluid">
                    <div>
                        <h3>50</h3>
                        <h5>order pending</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <div id="chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <div id="chart-order"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-sm-4 g-3">
        <div class="col-12">
            <div class="dashboard-table">
                <div class="wallet-table">
                    <div class="top-sec mb-3">
                        <h3>trending products</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table cart-table order-table">
                            <thead>
                            <tr>
                                <th>image</th>
                                <th>product name</th>
                                <th>price</th>
                                <th>sales</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="image-box">
                                    <img src="{!! asset('assets/images/fashion-1/product/5.jpg') !!}" alt="" class="blur-up lazyloaded">
                                </td>
                                <td>neck velvet dress</td>
                                <td>$205</td>
                                <td>1000</td>
                            </tr>
                            <tr>
                                <td class="image-box">
                                    <img src="{!! asset('assets/images/fashion-1/product/13.jpg') !!}" alt="" class="blur-up lazyloaded">
                                </td>
                                <td>belted trench coat</td>
                                <td>$350</td>
                                <td>800</td>
                            </tr>
                            <tr>
                                <td class="image-box">
                                    <img src="{!! asset('assets/images/fashion-1/product/9.jpg') !!}" alt="" class="blur-up lazyloaded">
                                </td>
                                <td>man print tee</td>
                                <td>$150</td>
                                <td>750</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="dashboard-table">
                <div class="wallet-table">
                    <div class="top-sec mb-3">
                        <h3>recent orders</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table cart-table order-table">
                            <thead>
                            <tr>
                                <th>order id</th>
                                <th>product details</th>
                                <th>status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td>{{ $order->order?->order_number }}</td>
                                    <td>
                                        {{ $order->items->pluck('product_name')->implode(', ') }}
                                    </td>
                                    <td>
                                        @php
                                            $shippingStatus = $order->shipping_status;
                                            $statusClass = [
                                                'pending'   => 'bg-pending',
                                                'shipped'   => 'bg-credit',
                                                'delivered' => 'bg-completed',
                                                'cancelled' => 'bg-debit',
                                            ][$shippingStatus] ?? 'bg-default';
                                            $statusLabel = ucfirst($shippingStatus);
                                        @endphp

                                        <span class="badge {{ $statusClass }} custom-badge rounded-0">{{ $statusLabel }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No recent orders found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
