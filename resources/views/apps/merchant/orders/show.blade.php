<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Order TXIND953621</title>
    <style>
        /* ---------------------------------------
           RESET & GLOBAL STYLES
        ---------------------------------------- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
        img {
            display: block;
            max-width: 100%;
            height: auto;
        }
        button {
            cursor: pointer;
        }

        /* ---------------------------------------
           TOP NAVIGATION
        ---------------------------------------- */
        .aces-order-navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #fff;
            padding: 1rem 2rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        .aces-order-navbar-left {
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        .aces-order-navbar-left h1 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-right: 1rem;
        }
        .aces-order-search-bar {
            position: relative;
            width: 300px;
        }
        .aces-order-search-bar input {
            width: 100%;
            padding: 0.5rem 2.5rem 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.9rem;
        }
        .aces-order-search-bar i {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }
        .aces-order-navbar-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .aces-order-user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            font-size: 0.85rem;
            margin-right: 0.5rem;
        }
        .aces-order-user-info .name {
            font-weight: bold;
        }
        .aces-order-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
        }

        /* ---------------------------------------
           MAIN CONTAINER
        ---------------------------------------- */
        .aces-order-container {
            max-width: 1200px;
            margin: 1.5rem auto;
            padding: 0 1rem;
        }

        /* ---------------------------------------
           ORDER HEADER
        ---------------------------------------- */
        .aces-order-order-header {
            background-color: #fff;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .aces-order-order-header-top {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }
        .aces-order-order-header-top h2 {
            font-size: 1.25rem;
            font-weight: 600;
        }
        .aces-order-order-header-top p {
            font-size: 0.95rem;
            color: #666;
            margin-top: 0.25rem;
        }
        .aces-order-order-actions {
            display: flex;
            gap: 0.5rem;
        }
        .aces-order-order-actions button {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            transition: background-color 0.2s;
        }
        .aces-order-order-actions button:hover {
            background-color: #f2f2f2;
        }

        /* ---------------------------------------
           ORDER STATUS ROW
        ---------------------------------------- */
        .aces-order-order-status-row {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .aces-order-status-card {
            flex: 1;
            min-width: 150px;
            background-color: #f9f9f9;
            border-radius: 6px;
            border: 1px solid #eee;
            padding: 0.75rem;
            text-align: center;
        }
        .aces-order-status-card h3 {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .aces-order-status-card span {
            font-size: 0.8rem;
            color: #999;
        }
        .aces-order-status-card.highlight {
            background-color: #ffe9d6;
            border-color: #ffc177;
        }

        /* ---------------------------------------
           MAIN CONTENT
        ---------------------------------------- */
        .aces-order-main-content {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        /* ---------------------------------------
           LEFT COLUMN (Addresses & Items)
        ---------------------------------------- */
        .aces-order-left-column {
            flex: 2;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .aces-order-info-box {
            background-color: #fff;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .aces-order-info-box h3 {
            font-size: 1rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        .aces-order-address-item {
            font-size: 0.9rem;
            color: #555;
            line-height: 1.4;
            margin-bottom: 0.5rem;
        }
        .aces-order-order-items {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .aces-order-item-row {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .aces-order-item-image {
            width: 60px;
            height: 60px;
            border-radius: 4px;
            overflow: hidden;
            flex-shrink: 0;
        }
        .aces-order-item-details {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            font-size: 0.9rem;
        }
        .aces-order-item-name {
            font-weight: bold;
        }
        .aces-order-order-summary {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #ddd;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            font-size: 0.9rem;
        }
        .aces-order-order-summary-row {
            display: flex;
            justify-content: space-between;
        }
        .aces-order-order-summary-row strong {
            font-weight: 600;
        }

        /* ---------------------------------------
           RIGHT COLUMN (Timeline)
        ---------------------------------------- */
        .aces-order-right-column {
            flex: 1;
            background-color: #fff;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .aces-order-timeline {
            display: flex;
            flex-direction: column;
            position: relative;
            margin: 1rem 0;
            padding-left: 1rem;
        }
        .aces-order-timeline::before {
            content: "";
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #ddd;
        }
        .aces-order-timeline-step {
            position: relative;
            display: flex;
            flex-direction: column;
            margin-bottom: 2rem;
            padding-left: 1.5rem;
        }
        .aces-order-timeline-step:last-child {
            margin-bottom: 0;
        }
        .aces-order-timeline-step::before {
            content: "";
            position: absolute;
            left: -0.58rem;
            top: 0;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: #fff;
            border: 2px solid #f90;
        }
        .aces-order-timeline-step h4 {
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .aces-order-timeline-step p {
            font-size: 0.85rem;
            color: #777;
        }
        .aces-order-right-column h3 {
            font-size: 1rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }
    </style>
</head>
<body>

<!-- Top Navigation -->
<div class="aces-order-navbar">
    <div class="aces-order-navbar-left">
        <h1>Transactions</h1>
        <div class="aces-order-search-bar">
            <input type="text" placeholder="Search for your invoice..." />
            <i>🔍</i>
        </div>
    </div>
    <div class="aces-order-navbar-right">
        <div class="aces-order-user-info">
            <span class="name">Ctrl xyz</span>
            <span class="email">[email protected]</span>
        </div>
        <div class="aces-order-user-avatar">
            <img src="https://source.unsplash.com/random/40x40?face" alt="User Avatar">
        </div>
    </div>
</div>

<!-- Main Container -->
<div class="aces-order-container">
    <!-- Order Header -->
    <div class="aces-order-order-header">
        <div class="aces-order-order-header-top">
            <div>
                <h2>Order ID : TXIND953621</h2>
                <p>No Resi : 34u455y566y</p>
            </div>
            <div class="aces-order-order-actions">
                <button>Send Invoice</button>
                <button>Contact Buyer</button>
            </div>
        </div>
        <!-- Order Status Row -->
        <div class="aces-order-order-status-row">
            <div class="aces-order-status-card">
                <h3>With courier in route</h3>
                <span>Order status</span>
            </div>
            <div class="aces-order-status-card">
                <h3>Order paid</h3>
                <span>Customer payment</span>
            </div>
            <div class="aces-order-status-card highlight">
                <h3>Shipped</h3>
                <span>On delivery</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="aces-order-main-content">
        <!-- Left Column -->
        <div class="aces-order-left-column">
            <!-- Shipping Addresses -->
            <div class="aces-order-info-box">
                <h3>Shipping Address (Seller)</h3>
                <div class="aces-order-address-item">John Seller</div>
                <div class="aces-order-address-item">123 Seller Street</div>
                <div class="aces-order-address-item">PSA 1532, Indonesia</div>
            </div>
            <div class="aces-order-info-box">
                <h3>Shipping Address (Buyer)</h3>
                <div class="aces-order-address-item">Alex Buyer</div>
                <div class="aces-order-address-item">99 Buyer Avenue</div>
                <div class="aces-order-address-item">PSA 1532, Indonesia</div>
            </div>
            <!-- Order Items & Summary -->
            <div class="aces-order-info-box">
                <h3>Order Items</h3>
                <div class="aces-order-order-items">
                    <div class="aces-order-item-row">
                        <div class="aces-order-item-image">
                            <img src="https://source.unsplash.com/random/80x80?shoes" alt="Sneaker">
                        </div>
                        <div class="aces-order-item-details">
                            <span class="aces-order-item-name">Sneaker</span>
                            <span>Qty: 1</span>
                            <span>Size: 42</span>
                        </div>
                    </div>
                    <div class="aces-order-item-row">
                        <div class="aces-order-item-image">
                            <img src="https://source.unsplash.com/random/80x80?jacket" alt="Jacket">
                        </div>
                        <div class="aces-order-item-details">
                            <span class="aces-order-item-name">Jacket</span>
                            <span>Qty: 1</span>
                            <span>Size: XL</span>
                        </div>
                    </div>
                </div>
                <div class="aces-order-order-summary">
                    <div class="aces-order-order-summary-row">
                        <span>Product Price</span>
                        <span>Rp 888.00</span>
                    </div>
                    <div class="aces-order-order-summary-row">
                        <span>Shipping</span>
                        <span>Rp 74.00</span>
                    </div>
                    <div class="aces-order-order-summary-row">
                        <span>Total Payment</span>
                        <span>Rp 140.00</span>
                    </div>
                    <div class="aces-order-order-summary-row">
                        <strong>Paid Status</strong>
                        <strong>Rp 876.50</strong>
                    </div>
                </div>
            </div>
        </div>
        <!-- Right Column (Timeline) -->
        <div class="aces-order-right-column">
            <h3>Tracking Progress</h3>
            <div class="aces-order-timeline">
                <div class="aces-order-timeline-step">
                    <h4>Ordered</h4>
                    <p>Order created by buyer</p>
                </div>
                <div class="aces-order-timeline-step">
                    <h4>Packed</h4>
                    <p>Items packed by seller</p>
                </div>
                <div class="aces-order-timeline-step">
                    <h4>Shipped</h4>
                    <p>On delivery</p>
                </div>
                <div class="aces-order-timeline-step">
                    <h4>Delivered</h4>
                    <p>Order completed</p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
