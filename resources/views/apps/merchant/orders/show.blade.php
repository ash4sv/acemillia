@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-table">


        <div class="aces-order-container">

            <!-- Title / Heading -->
            <h1 class="aces-order-title">ORDER DETAILS</h1>

            <!-- Order Number & Basic Info -->
            <div class="aces-order-header">
                <p class="aces-order-number">Order No. 1589186610</p>
                <p>On 10th October 2023 you ordered 1 item for home delivery</p>
                <p>Your delivery address is: <strong>John Newman</strong></p>
            </div>

            <!-- Delivery Info Box -->
            <div class="aces-order-delivery-info">
                <p class="aces-order-delivery-status">
                    Sit tight – we’re processing your order for delivery on
                    <strong>Thursday 12th October between 8am and 5pm</strong>
                </p>
                <a href="#" class="aces-order-reschedule-link">reschedule delivery</a>
            </div>

            <!-- Items List -->
            <div class="aces-order-items">
                <div class="aces-order-item">
                    <div class="aces-order-item-details">
                        <p class="aces-order-item-name">Chad Valley Wooden Fishing Set</p>
                        <p class="aces-order-item-code">890/4500</p>
                        <p class="aces-order-item-qty">Qty: 1</p>
                    </div>
                    <div class="aces-order-item-price">
                        £5.00
                    </div>
                </div>
            </div>

            <!-- Billing & Payment -->
            <div class="aces-order-billing-section">
                <div class="aces-order-billing-address">
                    <h3>Billing address</h3>
                    <p>John Newman</p>
                </div>
                <div class="aces-order-payment-method">
                    <h3>Payment method</h3>
                    <p>Mastercard Ending 9549</p>
                </div>
            </div>

            <!-- Summary -->
            <div class="aces-order-summary">
                <p>
                    <span>Item total:</span>
                    <span>£5.00</span>
                </p>
                <p>
                    <span>Delivery:</span>
                    <span>£2.95</span>
                </p>
                <p class="aces-order-total">
                    <span>Total:</span>
                    <span>£7.95</span>
                </p>
            </div>

            <!-- Example Form Element Using Bootstrap 5.3 Standard Size -->
            <form class="mt-4">
                <div class="mb-3">
                    <label for="exampleInput" class="form-label">Example Input</label>
                    <input type="text" class="form-control" id="exampleInput" placeholder="Enter text">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>

                {!! $order !!}

    </div>

@endsection
