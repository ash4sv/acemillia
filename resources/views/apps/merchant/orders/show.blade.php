@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-table">

        <!--
          STEP 1: TOP NAVIGATION
        -->
        <div class="navbar">
            <div class="navbar-left">
                <h1>Transactions</h1>
                <div class="search-bar">
                    <input type="text" placeholder="Search for your invoice..." />
                    <i>🔍</i>
                </div>
            </div>
            <div class="navbar-right">
                <div class="user-info">
                    <span class="name">Ctrl xyz</span>
                    <span class="email">[email protected]</span>
                </div>
                <div class="user-avatar">
                    <!-- Random user avatar from Unsplash -->
                    <img src="https://source.unsplash.com/random/40x40?face" alt="User Avatar">
                </div>
            </div>
        </div>

        <!--
          STEP 2: MAIN CONTAINER
        -->
        <div class="container">

            <!-- ORDER HEADER -->
            <div class="order-header">
                <div class="order-header-top">
                    <div>
                        <h2>Order ID : TXIND953621</h2>
                        <p>No Resi : 34u455y566y</p>
                    </div>
                    <div class="order-actions">
                        <button>Send Invoice</button>
                        <button>Contact Buyer</button>
                    </div>
                </div>

                <!-- ORDER STATUS (Example of 3 status cards) -->
                <div class="order-status-row">
                    <div class="status-card">
                        <h3>With courier in route</h3>
                        <span>Order status</span>
                    </div>
                    <div class="status-card">
                        <h3>Order paid</h3>
                        <span>Customer payment</span>
                    </div>
                    <div class="status-card highlight">
                        <h3>Shipped</h3>
                        <span>On delivery</span>
                    </div>
                </div>
            </div>

            <!-- MAIN CONTENT: LEFT (Addresses & Items) + RIGHT (Timeline) -->
            <div class="main-content">

                <!-- LEFT COLUMN -->
                <div class="left-column">

                    <!-- Shipping Addresses -->
                    <div class="info-box">
                        <h3>Shipping Address (Seller)</h3>
                        <div class="address-item">John Seller</div>
                        <div class="address-item">123 Seller Street</div>
                        <div class="address-item">PSA 1532, Indonesia</div>
                    </div>

                    <div class="info-box">
                        <h3>Shipping Address (Buyer)</h3>
                        <div class="address-item">Alex Buyer</div>
                        <div class="address-item">99 Buyer Avenue</div>
                        <div class="address-item">PSA 1532, Indonesia</div>
                    </div>

                    <!-- Order Items & Summary -->
                    <div class="info-box">
                        <h3>Order Items</h3>
                        <div class="order-items">
                            <!-- Item 1 -->
                            <div class="item-row">
                                <div class="item-image">
                                    <!-- Random sneaker image -->
                                    <img src="https://source.unsplash.com/random/80x80?shoes" alt="Sneaker">
                                </div>
                                <div class="item-details">
                                    <span class="item-name">Sneaker</span>
                                    <span>Qty: 1</span>
                                    <span>Size: 42</span>
                                </div>
                            </div>
                            <!-- Item 2 -->
                            <div class="item-row">
                                <div class="item-image">
                                    <!-- Random jacket image -->
                                    <img src="https://source.unsplash.com/random/80x80?jacket" alt="Jacket">
                                </div>
                                <div class="item-details">
                                    <span class="item-name">Jacket</span>
                                    <span>Qty: 1</span>
                                    <span>Size: XL</span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="order-summary">
                            <div class="order-summary-row">
                                <span>Product Price</span>
                                <span>Rp 888.00</span>
                            </div>
                            <div class="order-summary-row">
                                <span>Shipping</span>
                                <span>Rp 74.00</span>
                            </div>
                            <div class="order-summary-row">
                                <span>Total Payment</span>
                                <span>Rp 140.00</span>
                            </div>
                            <div class="order-summary-row">
                                <strong>Paid Status</strong>
                                <strong>Rp 876.50</strong>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN: TIMELINE -->
                <div class="right-column">
                    <h3>Tracking Progress</h3>
                    <div class="timeline">
                        <div class="timeline-step">
                            <h4>Ordered</h4>
                            <p>Order created by buyer</p>
                        </div>
                        <div class="timeline-step">
                            <h4>Packed</h4>
                            <p>Items packed by seller</p>
                        </div>
                        <div class="timeline-step">
                            <h4>Shipped</h4>
                            <p>On delivery</p>
                        </div>
                        <div class="timeline-step">
                            <h4>Delivered</h4>
                            <p>Order completed</p>
                        </div>
                    </div>
                </div>

            </div><!-- /.main-content -->

        </div><!-- /.container -->

        {!! $order !!}

    </div>

@endsection
