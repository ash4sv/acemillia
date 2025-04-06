@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-table">
        <div class="wallet-table">
            <div class="top-sec">
                <h3>{!! __('Orders') !!}</h3>
                {{--<a href="#!" class="btn btn-sm btn-solid">add product</a>--}}
            </div>
            <div class="table-responsive">
                <table class="table cart-table order-table">
                    <thead>
                    <tr>
                        <th>{!! __('Order Id') !!}</th>
                        <th>{!! __('Customer Name') !!}</th>
                        <th>{!! __('Shipping Status') !!}</th>
                        <th>{!! __('Price') !!}</th>
                        <th>{!! __('Date') !!}</th>
                        <th>{!! __('Action') !!}</th>
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
                            <td>{!! $subOrder->created_at->format('d M Y h:i:A') !!}</td>
                            <td><a href="#!"><i class="ri-eye-line"></i></a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {!! $subOrders->links('apps.layouts.pagination-custom-user') !!}

        </div>
    </div>

@endsection
