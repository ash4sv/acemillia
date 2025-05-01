@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="tab-pane fade show active" id="order-tab-pane" role="tabpanel">
        <div class="row">
            <div class="card mb-0 dashboard-table mt-0">
                <div class="card-body">
                    <div class="top-sec">
                        <h3>{!! __('My Orders') !!}</h3>
                    </div>
                    <div class="total-box mt-0">
                        <div class="wallet-table mt-0">
                            <div class="table-responsive">
                                <table class="table cart-table order-table">
                                    <thead>
                                    <tr class="table-head">
                                        <th>{!! __('Order Number') !!}</th>
                                        <th>{!! __('Amount') !!}</th>
                                        <th>{!! __('Payment Status') !!}</th>
                                        <th>{!! __('Status') !!}</th>
                                        <th>{!! __('Date') !!}</th>
                                        <th>{!! __('Option') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($orders as $n => $order)
                                    <tr>
                                        <td><span class="fw-bolder">{{ $order->order_number }}</span></td>
                                        <td class="text-theme">{!! $order->total_amount !!}</td>
                                        <td>
                                            @php
                                                $status = $order->payment_status;
                                                $statusClass = [
                                                    'pending' => 'bg-pending',
                                                    'paid'    => 'bg-completed',
                                                    'failed'  => 'bg-cancelled',
                                                ][$status] ?? 'bg-default';
                                                $statusLabel = ucfirst($status);
                                            @endphp

                                            <div class="badge {{ $statusClass }} custom-badge rounded-0">
                                                <span>{{ $statusLabel }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $status = $order->status;
                                                $statusClass = [
                                                    'processing' => 'bg-pending',
                                                    'completed'  => 'bg-completed',
                                                    'cancelled'  => 'bg-cancelled',
                                                ][$status] ?? 'bg-default';
                                                $statusLabel = ucfirst($status);
                                            @endphp

                                            <div class="badge {{ $statusClass }} custom-badge rounded-0">
                                                <span>{{ $statusLabel }}</span>
                                            </div>
                                        </td>
                                        <td>{!! $order->created_at->format('d M Y h:i:A') !!}</td>
                                        <td><a href="{!! route('dashboard', ['section' => 'my-order-show', 'id' => $order->id]) !!}"><i class="ri-eye-line"></i></a></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="d-flex align-items-center justify-content-center" style="min-height:10rem;">
                                                <h3 class="m-0 text-center fw-lighter" style="font-size: 24px;">
                                                    {{ __('You haven’t placed any orders yet—start shopping and your purchases will appear here.') }}
                                                </h3>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {!! $orders->links('apps.layouts.pagination-custom-user') !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
