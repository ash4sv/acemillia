@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="tab-pane fade show active" id="order-tab-pane" role="tabpanel">
        <div class="row">
            <div class="card mb-0 dashboard-table mt-0">
                <div class="card-body">
                    <div class="top-sec">
                        <h3>My Orders</h3>
                    </div>
                    <div class="total-box mt-0">
                        <div class="wallet-table mt-0">
                            <div class="table-responsive">
                                <table class="table cart-table order-table">
                                    <thead>
                                    <tr class="table-head">
                                        <th>Order Number</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Payment Status</th>
                                        <th>Payment Method</th>
                                        <th>Option</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($orders as $n => $order)
                                    <tr>
                                        <td><span class="fw-bolder">#1020</span></td>
                                        <td>{!! $order->created_at->format('d M Y h:i:A') !!}</td>
                                        <td>{!! $order->total_amount !!}</td>
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
                                        <td>COD</td>
                                        <td><a href="#!"><i class="ri-eye-line"></i></a></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6"></td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="product-pagination">
                            <div class="theme-pagination-block">
                                <nav>
                                    <ul class="pagination">
                                        <li class="page-item">
                                            <a class="page-link" href="#!" aria-label="Previous">
                                                <span>
                                                    <i class="ri-arrow-left-s-line"></i>
                                                </span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        <li class="page-item active">
                                            <a class="page-link" href="#!">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#!">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#!">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#!" aria-label="Next">
                                                <span>
                                                    <i class="ri-arrow-right-s-line"></i>
                                                </span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
