@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-table">

        <main class="aces-order-main">

            <!-- Order Details -->
            <div class="aces-order-box aces-order-order-details">
                <h2 class="aces-order-box-title">Order Details</h2>
                <div class="aces-order-row">
                    <div class="aces-order-label">Order Number:</div>
                    <div class="aces-order-value">100041</div>
                </div>
                <div class="aces-order-row">
                    <div class="aces-order-label">Order Date:</div>
                    <div class="aces-order-value">February 17, 2015</div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="aces-order-box aces-order-shipping-info">
                <h2 class="aces-order-box-title">Shipping Information</h2>
                <div class="aces-order-row">
                    <div class="aces-order-label">Shipping Address:</div>
                    <div class="aces-order-value">1234 Elm Street, Anytown, USA</div>
                </div>
                <div class="aces-order-row">
                    <div class="aces-order-label">Shipping Method:</div>
                    <div class="aces-order-value">Standard Shipping</div>
                </div>
                <div class="aces-order-row">
                    <div class="aces-order-label">Ship as completed:</div>
                    <div class="aces-order-value">Yes</div>
                </div>
                <div class="aces-order-row">
                    <div class="aces-order-label">Shipping Cost:</div>
                    <div class="aces-order-value">$5.00</div>
                </div>
                <div class="aces-order-row">
                    <div class="aces-order-label">Status:</div>
                    <div class="aces-order-value">Processing</div>
                </div>
            </div>

            <!-- Product -->
            <div class="aces-order-box aces-order-product">
                <h2 class="aces-order-box-title">Product</h2>
                <div class="aces-order-row">
                    <div class="aces-order-label">Product Name:</div>
                    <div class="aces-order-value">Reading Tablet</div>
                </div>
                <div class="aces-order-row">
                    <div class="aces-order-label">SKU:</div>
                    <div class="aces-order-value">CN3203</div>
                </div>
                <div class="aces-order-row">
                    <div class="aces-order-label">Memory:</div>
                    <div class="aces-order-value">32GB</div>
                </div>
                <div class="aces-order-row">
                    <div class="aces-order-label">Battery Life:</div>
                    <div class="aces-order-value">72 hours</div>
                </div>
                <div class="aces-order-row">
                    <div class="aces-order-label">Order Status:</div>
                    <div class="aces-order-value">Processing</div>
                </div>
                <div class="aces-order-row">
                    <div class="aces-order-label">Date Shipped:</div>
                    <div class="aces-order-value">-</div>
                </div>
                <hr class="aces-order-divider">
                <div class="aces-order-row aces-order-price-detail">
                    <div class="aces-order-label">Cost:</div>
                    <div class="aces-order-value">$75.00</div>
                </div>
                <div class="aces-order-row aces-order-price-detail">
                    <div class="aces-order-label">Qty:</div>
                    <div class="aces-order-value">1</div>
                </div>
                <div class="aces-order-row aces-order-price-detail">
                    <div class="aces-order-label">Subtotal:</div>
                    <div class="aces-order-value">$75.00</div>
                </div>
                <div class="aces-order-row aces-order-price-detail">
                    <div class="aces-order-label">Shipping:</div>
                    <div class="aces-order-value">$5.00</div>
                </div>
                <div class="aces-order-row aces-order-price-detail">
                    <div class="aces-order-label">Tax:</div>
                    <div class="aces-order-value">$0.00</div>
                </div>
                <div class="aces-order-row aces-order-price-detail aces-order-grand-total">
                    <div class="aces-order-label">Grand Total:</div>
                    <div class="aces-order-value">$80.00</div>
                </div>
            </div>

            <!-- Billing Information -->
            <div class="aces-order-box aces-order-billing-info">
                <h2 class="aces-order-box-title">Billing Information</h2>
                <div class="aces-order-row">
                    <div class="aces-order-label">Billing Address:</div>
                    <div class="aces-order-value">1234 Elm Street, Anytown, USA</div>
                </div>
                <div class="aces-order-row">
                    <div class="aces-order-label">Billing Method:</div>
                    <div class="aces-order-value">Cash on Delivery</div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="aces-order-actions">
                <button class="aces-order-btn aces-order-btn-cancel" type="button">Cancel</button>
                <button class="aces-order-btn aces-order-btn-print" type="button">Print</button>
                <button class="aces-order-btn aces-order-btn-send" type="button">Send Message</button>
            </div>

                {!! $order !!}

    </div>

@endsection
