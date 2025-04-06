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

            @if ($orders->lastPage() > 1)
                <div class="product-pagination">
                    <div class="theme-pagination-block">
                        <nav>
                            <ul class="pagination">

                                {{-- Previous Button --}}
                                <li class="page-item {{ $orders->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $orders->previousPageUrl() }}" aria-label="Previous">
                                        <span><i class="ri-arrow-left-s-line"></i></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>

                                {{-- Page Numbers --}}
                                @for ($i = 1; $i <= $orders->lastPage(); $i++)
                                    <li class="page-item {{ $orders->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $orders->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                {{-- Next Button --}}
                                <li class="page-item {{ !$orders->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $orders->nextPageUrl() }}" aria-label="Next">
                                        <span><i class="ri-arrow-right-s-line"></i></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>

                            </ul>
                        </nav>
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection
