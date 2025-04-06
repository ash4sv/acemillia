@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-table">
        <div class="wallet-table">
            <div class="top-sec">
                <h3>orders</h3>
                {{--<a href="#!" class="btn btn-sm btn-solid">add product</a>--}}
            </div>
            <div class="table-responsive">
                <table class="table cart-table order-table">
                    <thead>
                    <tr>
                        <th>{!! ucfirst('Order Id') !!}</th>
                        <th>{!! ucfirst('Customer Name') !!}</th>
                        <th>{!! ucfirst('Status') !!}</th>
                        <th>{!! ucfirst('Price') !!}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($subOrders as $i => $subOrder)
                        <tr>
                            <td>#125021</td>
                            <td>{!! $subOrder->order->user?->name !!}</td>
                            <td>
                                @php
                                    $shippingStatus = $subOrder->shipping_status;
                                    $statusClass = [
                                        'pending'   => 'bg-pending',
                                        'shipped'   => 'bg-credit',
                                        'delivered' => 'bg-completed',
                                        'cancelled' => 'bg-debit',
                                    ][$shippingStatus] ?? 'bg-default';
                                    $statusLabel = ucfirst($shippingStatus);
                                @endphp

                                <span class="badge {!! $statusClass !!} custom-badge rounded-0">{!! $statusLabel !!}</span>
                            </td>
                            <td>{!! $subOrder->subtotal !!}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4"></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {!! $subOrders->links('apps.layouts.pagination-custom-user') !!}

        </div>
    </div>

@endsection
