@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-table">
        <div class="aces-order-container">
            <!-- Order Header -->
            <div class="aces-order-order-header">
                <div class="aces-order-order-core">
                    <div class="aces-order-order-info">
                        <h2>Order ID: TXIND953621</h2>
                        <p>No Resi: 34u455y566y</p>
                        <p>Shipping Method: Standard Delivery</p>
                        <p>Estimated Delivery: April 10, 2025</p>
                    </div>
                    <div class="aces-order-order-actions">
                        <button class="aces-order-btn aces-order-btn-primary">Send Invoice</button>
                        <button class="aces-order-btn aces-order-btn-secondary">Contact Buyer</button>
                        <button class="aces-order-btn aces-order-btn-secondary">Print Order</button>
                    </div>
                </div>
                <div class="aces-order-status-cards">
                    <div class="aces-order-status-card">
                        <h3>Order Placed</h3>
                        <span>Confirmed</span>
                    </div>
                    <div class="aces-order-status-card">
                        <h3>Order Paid</h3>
                        <span>Payment Received</span>
                    </div>
                    <div class="aces-order-status-card aces-order-current-status">
                        <h3>Shipped</h3>
                        <span>In Transit</span>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="aces-order-main-content">
                <div class="aces-order-left-column">
                    <!-- Addresses (Grouped Side-by-Side) -->
                    <div class="aces-order-addresses">
                        <div class="aces-order-address aces-order-seller-address">
                            <h3>Shipping Address (Seller)</h3>
                            <p>John Seller</p>
                            <p>123 Seller Street</p>
                            <p>PSA 1532, Indonesia</p>
                        </div>
                        <div class="aces-order-address aces-order-buyer-address">
                            <h3>Shipping Address (Buyer)</h3>
                            <p>Alex Buyer</p>
                            <p>99 Buyer Avenue</p>
                            <p>PSA 1532, Indonesia</p>
                        </div>
                    </div>
                    <!-- Order Items & Summary -->
                    <div class="aces-order-order-items-box">
                        <h3>Order Items</h3>
                        <div class="aces-order-order-items">
                            <div class="aces-order-item-row">
                                <div class="aces-order-item-image">
                                    <img src="https://source.unsplash.com/random/80x80?shoes" alt="Sneaker">
                                </div>
                                <div class="aces-order-item-details">
                                    <p class="aces-order-item-name">Sneaker</p>
                                    <p>Qty: 1 | Size: 42</p>
                                </div>
                            </div>
                            <div class="aces-order-item-row">
                                <div class="aces-order-item-image">
                                    <img src="https://source.unsplash.com/random/80x80?jacket" alt="Jacket">
                                </div>
                                <div class="aces-order-item-details">
                                    <p class="aces-order-item-name">Jacket</p>
                                    <p>Qty: 1 | Size: XL</p>
                                </div>
                            </div>
                        </div>
                        <div class="aces-order-order-summary">
                            <div class="aces-order-summary-row">
                                <span>Product Price</span>
                                <span>Rp 888.00</span>
                            </div>
                            <div class="aces-order-summary-row">
                                <span>Shipping</span>
                                <span>Rp 74.00</span>
                            </div>
                            <div class="aces-order-summary-row aces-order-summary-total">
                                <strong>Total Payment</strong>
                                <strong>Rp 140.00</strong>
                            </div>
                            <div class="aces-order-summary-row">
                                <span>Paid Status</span>
                                <span>Rp 876.50</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {!! $order !!}

    </div>

@endsection
