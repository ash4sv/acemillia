@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-table">

        <!-- MAIN CONTAINER -->
        <div class="aces-order-main-container">

            <!-- MAIN CONTENT -->
            <main class="aces-order-content">

                <!-- 1. Order Details -->
                <section class="aces-order-order-box">
                    <h2 class="aces-order-box-title">Order Details</h2>
                    <p><strong>Order Number:</strong> 100041</p>
                    <p><strong>Order Date:</strong> February 17, 2015</p>
                </section>

                <!-- 2. Shipping Information -->
                <section class="aces-order-order-box">
                    <h2 class="aces-order-box-title">Shipping Information</h2>
                    <p><strong>Shipping Address:</strong> 1234 Elm Street, Anytown, USA</p>
                    <p><strong>Shipping Method:</strong> Standard Shipping</p>
                    <p><strong>Ship as completed:</strong> Yes</p>
                    <p><strong>Shipping Cost:</strong> $5.00</p>
                    <p><strong>Status:</strong> Processing</p>
                </section>

                <!-- 3. Product (Object) -->
                <section class="aces-order-order-box">
                    <h2 class="aces-order-box-title">Product</h2>
                    <p><strong>Reading Tablet</strong></p>
                    <p>SKU: CN3203</p>
                    <p>Memory: 32GB</p>
                    <p>Battery Life: 72 hours</p>
                    <p><strong>Order Status:</strong> Processing</p>
                    <p><strong>Date Shipped:</strong> -</p>
                    <hr />
                    <p><strong>Cost:</strong> $75.00</p>
                    <p><strong>Qty:</strong> 1</p>
                    <p><strong>Subtotal:</strong> $75.00</p>
                    <p><strong>Shipping:</strong> $5.00</p>
                    <p><strong>Tax:</strong> $0.00</p>
                    <p><strong>Grand Total:</strong> $80.00</p>
                </section>

                <!-- 4. Billing Information -->
                <section class="aces-order-order-box">
                    <h2 class="aces-order-box-title">Billing Information</h2>
                    <p><strong>Billing Address:</strong> 1234 Elm Street, Anytown, USA</p>
                    <p><strong>Billing Method:</strong> Cash on Delivery</p>
                </section>

                <!-- ACTION BUTTONS -->
                <div class="aces-order-order-actions">
                    <button type="button" class="aces-order-btn-cancel">Cancel</button>
                    <button type="button" class="aces-order-btn-print">Print</button>
                    <button type="button" class="aces-order-btn-send">Send Message</button>
                </div>

            </main>

        </div>

                {!! $order !!}

    </div>

@endsection
