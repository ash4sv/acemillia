@extends('apps.layouts.shop')

@php
    $title = 'Dashboard';
@endphp

@section('description', '')
@section('keywords', '')
@section('author', '')
@section('title', $title)

@push('style')

@endpush

@push('script')

@endpush

@section('webpage')

    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <h2>@yield('title')</h2>
            <nav class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{!! url('/') !!}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">{!! strtoupper($title) !!}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!--  dashboard section start -->
    <section class="dashboard-section section-b-space user-dashboard-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="dashboard-sidebar">
                        <button class="btn back-btn">
                            <i class="ri-close-line"></i><span>Close</span>
                        </button>
                        <div class="profile-top">
                            <div class="profile-top-box">
                                <div class="profile-image">
                                    <div class="position-relative">
                                        <div class="user-round">
                                            <h4>J</h4>
                                        </div>
                                        <div class="user-icon">
                                            <input type="file" accept="image/*">
                                            <i class="ri-image-edit-line d-lg-block d-none"></i>
                                            <i class="ri-pencil-fill edit-icon d-lg-none"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-detail">
                                <h5>{{ $authUser->name }}</h5>
                                <h6>{{ $authUser->email }}</h6>
                            </div>
                        </div>
                        <div class="faq-tab">
                            <ul id="pills-tab" role="tablist" class="nav nav-tabs">
                                <li role="presentation" class="nav-item">
                                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info-tab-pane" type="button" role="tab">
                                        <i class="ri-home-line"></i>
                                        dashboard
                                    </button>
                                </li>
                                <li role="presentation" class="nav-item">
                                    <button class="nav-link" id="notification-tab" data-bs-toggle="tab" data-bs-target="#notification-tab-pane" type="button" role="tab">
                                        <i class="ri-notification-line"></i>
                                        Notifications
                                    </button>
                                </li>
                                <li role="presentation" class="nav-item">
                                    <button class="nav-link" id="bank-details-tab" data-bs-toggle="tab" data-bs-target="#bank-details-tab-pane" type="button" role="tab">
                                        <i class="ri-bank-line"></i> Bank Details
                                    </button>
                                </li>
                                <li role="presentation" class="nav-item">
                                    <button class="nav-link" id="wallet-tab" data-bs-toggle="tab" data-bs-target="#wallet-tab-pane" type="button" role="tab">
                                        <i class="ri-wallet-line"></i> My Wallet
                                    </button>
                                </li>
                                <li role="presentation" class="nav-item">
                                    <button class="nav-link" id="earning" data-bs-toggle="tab" data-bs-target="#earning-tab-pane" type="button" role="tab">
                                        <i class="ri-coin-line"></i> Earning Points
                                    </button>
                                </li>
                                <li role="presentation" class="nav-item">
                                    <button class="nav-link" id="order-tab" data-bs-toggle="tab" data-bs-target="#order-tab-pane" type="button" role="tab">
                                        <i class="ri-file-text-line"></i>My Orders
                                    </button>
                                </li>

                                <li role="presentation" class="nav-item">
                                    <button class="nav-link" id="refund-tab" data-bs-toggle="tab" data-bs-target="#refund-tab-pane" type="button" role="tab">
                                        <i class="ri-money-dollar-circle-line"></i> Refund History </button>
                                </li>
                                <li role="presentation" class="nav-item">
                                    <button class="nav-link" id="address" data-bs-toggle="tab" data-bs-target="#address-tab-pane" type="button" role="tab">
                                        <i class="ri-map-pin-line"></i> Saved Address
                                    </button>
                                </li>
                                <li role="presentation" class="nav-item logout-cls">
                                    <a href="javascript:;" class="btn loagout-btn" onclick="Apps.logoutConfirm('user_log_out')">
                                        <i class="ri-logout-box-r-line"></i> Logout
                                    </a>
                                    <form id="user_log_out" action="{{ route('auth.destroy') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <button class="show-btn btn d-lg-none d-block">Show Menu</button>
                    <div class="faq-content tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="info-tab-pane" role="tabpanel">
                            <div class="counter-section">
                                <div class="welcome-msg">
                                    <h4>Hello, {!! $authUser->name !!} !</h4>
                                    <p>From your My Account Dashboard you have the ability to view a snapshot of your recent account activity and update your account information. Select a link below to view or edit information.</p>
                                </div>
                                {{--<div class="row">
                                    <div class="col-md-4">
                                        <div class="counter-box">
                                            <img src="{{ asset('assets/images/dashboard/balance.png') }}" alt="" class="img-fluid">
                                            <div>
                                                <h3>$12.46</h3>
                                                <h5>Total Order</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="counter-box">
                                            <img src="{{ asset('assets/images/dashboard/points.png') }}" alt="" class="img-fluid">
                                            <div>
                                                <h3>2530</h3>
                                                <h5>Total Points</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="counter-box">
                                            <img src="{{ asset('assets/images/dashboard/order.png') }}" alt="" class="img-fluid">
                                            <div>
                                                <h3>15</h3>
                                                <h5>Total Orders</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>--}}
                                <div class="box-account box-info">
                                    <div class="box-head">
                                        <h4>Account Information</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="box">
                                                <ul class="box-content">
                                                    <li class="w-100">
                                                        <h6>{{ $authUser->name }}</h6>
                                                    </li>
                                                    <li class="w-100">
                                                        <h6>Phone: +1 65558845</h6>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box mt-3">
                                        <div class="box-head">
                                            <h4>Login Details</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h6>Email : {{ $authUser->email }}</h6>
                                                <a href="#edit-profile" data-bs-toggle="modal">Edit</a>
                                            </div>
                                            <div class="col-sm-6">
                                                <h6>Password : ●●●●●●</h6>
                                                <a href="#edit-password" data-bs-toggle="modal">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="notification-tab-pane" role="tabpanel">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mb-0 mt-0 mb-0">
                                        <div class="card-body">
                                            <div class="top-sec">
                                                <h3>Notifications</h3>
                                            </div>
                                            <ul class="notification-list">
                                                <li>
                                                    <h4>Your order has been successfully placed. Order ID:
                                                        #1013. Thank you for
                                                        choosing us.</h4>
                                                    <h5><i class="ri-time-line"></i> 24 Jun 2024
                                                        02:29:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Your Refund request status has been rejected</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        05:42:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Your order has been successfully placed. Order ID:
                                                        #1012. Thank you for
                                                        choosing us.</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        05:18:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Your order has been successfully placed. Order ID:
                                                        #1011. Thank you for
                                                        choosing us.</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        05:18:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Your order has been successfully placed. Order ID:
                                                        #1010. Thank you for
                                                        choosing us.</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        04:29:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Your order has been successfully placed. Order ID:
                                                        #1009. Thank you for
                                                        choosing us.</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        03:57:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Order Update: Your order #1008 has been updated and
                                                        current order
                                                        status is in delivered. Thank you for your patience!</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        03:49:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Order Update: Your order #1008 has been updated and
                                                        current order
                                                        status is in pending. Thank you for your patience!</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        03:49:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Order Update: Your order #1007 has been updated and
                                                        current order
                                                        status is in delivered. Thank you for your patience!</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        03:49:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Your order has been successfully placed. Order ID:
                                                        #1006. Thank you for
                                                        choosing us.</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        03:48:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Your order has been successfully placed. Order ID:
                                                        #1005. Thank you for
                                                        choosing us.</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        03:45:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Order Update: Your order #1000 has been updated and
                                                        current order
                                                        status is in delivered. Thank you for your patience!</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        03:34:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Order Update: Your order #1003 has been updated and
                                                        current order
                                                        status is in cancelled. Thank you for your patience!</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        03:34:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Order Update: Your order #1004 has been updated and
                                                        current order
                                                        status is in delivered. Thank you for your patience!</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        03:34:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Order Update: Your order #1004 has been updated and
                                                        current order
                                                        status is in out_for_delivery. Thank you for your patience!</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        03:34:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Order Update: Your order #1004 has been updated and
                                                        current order
                                                        status is in shipped. Thank you for your patience!</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        03:34:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Order Update: Your order #1004 has been updated and
                                                        current order
                                                        status is in processing. Thank you for your patience!</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        03:34:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Your order has been successfully placed. Order ID:
                                                        #1004. Thank you for
                                                        choosing us.</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        03:14:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Your order has been successfully placed. Order ID:
                                                        #1003. Thank you for
                                                        choosing us.</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        03:10:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Your order has been successfully placed. Order ID:
                                                        #1002. Thank you for
                                                        choosing us.</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        03:07:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Your order has been successfully placed. Order ID:
                                                        #1001. Thank you for
                                                        choosing us.</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        03:02:PM</h5>
                                                </li>
                                                <li>
                                                    <h4>Your order has been successfully placed. Order ID:
                                                        #1000. Thank you for
                                                        choosing us.</h4>
                                                    <h5><i class="ri-time-line"></i> 21 Jun 2024
                                                        03:00:PM</h5>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="bank-details-tab-pane" role="tabpanel">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mb-0 mt-0">
                                        <div class="card-body">
                                            <div class="top-sec">
                                                <h3>Bank Details</h3>
                                            </div>
                                            <form class="themeform-auth">
                                                <div class="row mb-3 align-items-center">
                                                    <label for="bank_account_no"
                                                        class="form-label col-xxl-2 col-lg-12 col-md-3">Bank Account
                                                        Number</label>
                                                    <div class="col-xxl-10 col-lg-12 col-md-9">
                                                        <input type="text" id="bank_account_no" class="form-control"
                                                            placeholder="Enter Bank Account Number">
                                                    </div>
                                                </div>
                                                <div class="row mb-3 align-items-center">
                                                    <label for="bank_name"
                                                        class="form-label col-xxl-2 col-lg-12 col-md-3">Bank
                                                        Name</label>
                                                    <div class="col-xxl-10 col-lg-12 col-md-9"><input type="text"
                                                            id="bank_name" class="form-control"
                                                            placeholder="Enter Bank Name">
                                                    </div>
                                                </div>
                                                <div class="row mb-3 align-items-center">
                                                    <label for="bank_holder_name"
                                                        class="form-label col-xxl-2 col-lg-12 col-md-3">Holder
                                                        Name</label>
                                                    <div class="col-xxl-10 col-lg-12 col-md-9"><input type="text"
                                                            id="bank_holder_name" class="form-control"
                                                            placeholder="Enter Bank Holder Name">
                                                    </div>
                                                </div>
                                                <div class="row mb-3 align-items-center">
                                                    <label for="swift"
                                                        class="form-label col-xxl-2 col-lg-12 col-md-3">Swift</label>
                                                    <div class="col-xxl-10 col-lg-12 col-md-9">
                                                        <input type="text" id="swift" class="form-control"
                                                            placeholder="Enter Swift Code">
                                                    </div>
                                                </div>
                                                <div class="row mb-3 align-items-center">
                                                    <label for="ifsc"
                                                        class="form-label col-xxl-2 col-lg-12 col-md-3">IFSC</label>
                                                    <div class="col-xxl-10 col-lg-12 col-md-9">
                                                        <input type="text" id="ifsc" class="form-control"
                                                            placeholder="Enter IFSC Code">
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="mb-3 top-sec top-sec-2">
                                                <h3>Payment Details</h3>
                                            </div>
                                            <form class="themeform-auth">
                                                <div class="row mb-3 align-items-center">
                                                    <label for="paypal_email"
                                                        class="form-label col-xxl-2 col-lg-12 col-md-3">Paypal
                                                        Email</label>
                                                    <div class="col-xxl-10 col-lg-12 col-md-9">
                                                        <input type="email" id="paypal_email" class="form-control "
                                                            placeholder="Enter Paypal Email">
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <button class="btn btn-solid" id="payout_btn" type="submit"> Save
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="wallet-tab-pane" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="total-contain wallet-bg">
                                        <div class="wallet-point-box">
                                            <div class="total-image">
                                                <img src="../assets/images/dashboard/balance.png" alt=""
                                                    class="img-fluid">
                                            </div>
                                            <div class="total-detail">
                                                <div class="total-box">
                                                    <h5>Wallet Balance</h5>
                                                    <h3>$8.46</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card mb-0 dashboard-table mt-0">
                                        <div class="card-body">
                                            <div class="total-box mt-0">
                                                <div class="wallet-table">
                                                    <div class="table-responsive">
                                                        <table class="table cart-table order-table">
                                                            <thead>
                                                                <tr class="table-head">
                                                                    <th>Date</th>
                                                                    <th>Amount</th>
                                                                    <th>Remark</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>06 Jul 2024
                                                                        03:15:PM</td>
                                                                    <td>$39.40</td>
                                                                    <td>Wallet amount
                                                                        successfully debited for Order #1017</td>
                                                                    <td>
                                                                        <div
                                                                            class="badge bg-debit custom-badge rounded-0">
                                                                            <span>Debit</span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>25 Jun 2024
                                                                        06:34:PM</td>
                                                                    <td>$375.00</td>
                                                                    <td>Wallet amount
                                                                        successfully debited for Order #1015</td>
                                                                    <td>
                                                                        <div
                                                                            class="badge bg-debit custom-badge rounded-0">
                                                                            <span>Debit</span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>24 Jun 2024
                                                                        02:29:PM</td>
                                                                    <td>$34.44</td>
                                                                    <td>Wallet amount
                                                                        successfully debited for Order #1013</td>
                                                                    <td>
                                                                        <div
                                                                            class="badge bg-debit custom-badge rounded-0">
                                                                            <span>Debit</span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>21 Jun 2024
                                                                        04:29:PM</td>
                                                                    <td>$75.21</td>
                                                                    <td>Wallet amount
                                                                        successfully debited for Order #1010</td>
                                                                    <td>
                                                                        <div
                                                                            class="badge bg-debit custom-badge rounded-0">
                                                                            <span>Debit</span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>21 Jun 2024
                                                                        03:57:PM</td>
                                                                    <td>$30.52</td>
                                                                    <td>Wallet amount
                                                                        successfully debited for Order #1009</td>
                                                                    <td>
                                                                        <div
                                                                            class="badge bg-debit custom-badge rounded-0">
                                                                            <span>Debit</span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>21 Jun 2024
                                                                        03:48:PM</td>
                                                                    <td>$109.97</td>
                                                                    <td>Wallet amount
                                                                        successfully debited for Order #1006</td>
                                                                    <td>
                                                                        <div
                                                                            class="badge bg-debit custom-badge rounded-0">
                                                                            <span>Debit</span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>21 Jun 2024
                                                                        03:42:PM</td>
                                                                    <td>$323.00</td>
                                                                    <td>Admin has credited
                                                                        the balance.</td>
                                                                    <td>
                                                                        <div
                                                                            class="badge bg-credit custom-badge rounded-0">
                                                                            <span>Credit</span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>21 Jun 2024
                                                                        03:41:PM</td>
                                                                    <td>$250.00</td>
                                                                    <td>Admin has debited
                                                                        the balance.</td>
                                                                    <td>
                                                                        <div
                                                                            class="badge bg-debit custom-badge rounded-0">
                                                                            <span>Debit</span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>21 Jun 2024
                                                                        03:41:PM</td>
                                                                    <td>$500.00</td>
                                                                    <td>Admin has credited
                                                                        the balance.</td>
                                                                    <td>
                                                                        <div
                                                                            class="badge bg-credit custom-badge rounded-0">
                                                                            <span>Credit</span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>21 Jun 2024
                                                                        03:41:PM</td>
                                                                    <td>$100.00</td>
                                                                    <td>Admin has credited
                                                                        the balance.</td>
                                                                    <td>
                                                                        <div
                                                                            class="badge bg-credit custom-badge rounded-0">
                                                                            <span>Credit</span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="product-pagination">
                                                    <div class="theme-paggination-block">
                                                        <nav>
                                                            <ul class="pagination">
                                                                <li class="page-item">
                                                                    <a class="page-link" href="#!"
                                                                        aria-label="Previous">
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
                        </div>
                        <div class="tab-pane fade" id="earning-tab-pane" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="total-contain wallet-bg">
                                        <div class="wallet-point-box">
                                            <div class="total-image">
                                                <img src="../assets/images/dashboard/points.png" alt=""
                                                    class="img-fluid">
                                            </div>
                                            <div class="total-detail">
                                                <div class="total-box">
                                                    <h5>Total Points</h5>
                                                    <h3>1970</h3>
                                                </div>
                                                <div class="point-ratio">
                                                    <h3 class="counter"><i class="ri-information-line"></i>
                                                        1 Points =
                                                        $0.03 Balance </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="dashboard-table">
                                        <div class="wallet-table">
                                            <div class="table-responsive">
                                                <table class="table cart-table order-table">
                                                    <thead>
                                                        <tr class="table-head">
                                                            <th>Date</th>
                                                            <th>Points</th>
                                                            <th>Remark</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="">
                                                            <td>06 Jul 2024 03:15:PM</td>
                                                            <td>$39.40</td>
                                                            <td>Wallet amount successfully debited for Order #1017</td>
                                                            <td>
                                                                <div class="badge bg-debit custom-badge rounded-0">
                                                                    <span>Debit</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>25 Jun 2024 06:34:PM</td>
                                                            <td>$375.00</td>
                                                            <td>Wallet amount successfully debited for Order #1015</td>
                                                            <td>
                                                                <div class="badge bg-debit custom-badge rounded-0">
                                                                    <span>Debit</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>24 Jun 2024 02:29:PM</td>
                                                            <td>$34.44</td>
                                                            <td>Wallet amount successfully debited for Order #1013</td>
                                                            <td>
                                                                <div class="badge bg-debit custom-badge rounded-0">
                                                                    <span>Debit</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>21 Jun 2024 04:29:PM</td>
                                                            <td>$75.21</td>
                                                            <td>Wallet amount successfully debited for Order #1010</td>
                                                            <td>
                                                                <div class="badge bg-debit custom-badge rounded-0">
                                                                    <span>Debit</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>21 Jun 2024 03:57:PM</td>
                                                            <td>$30.52</td>
                                                            <td>Wallet amount successfully debited for Order #1009</td>
                                                            <td>
                                                                <div class="badge bg-debit custom-badge rounded-0">
                                                                    <span>Debit</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>21 Jun 2024 03:41:PM</td>
                                                            <td>$500.00</td>
                                                            <td>Admin has credited the balance.</td>
                                                            <td>
                                                                <div class="badge bg-credit custom-badge rounded-0">
                                                                    <span>Credit</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-pagination">
                                        <div class="theme-paggination-block">
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
                        <div class="tab-pane fade" id="order-tab-pane" role="tabpanel">
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
                                                            <tr>
                                                                <td><span class="fw-bolder">#1020</span></td>
                                                                <td>06 Jul 2024 03:51:PM
                                                                </td>
                                                                <td>$61.73</td>
                                                                <td>
                                                                    <div
                                                                        class="badge bg-pending custom-badge rounded-0">
                                                                        <span>Pending</span>
                                                                    </div>
                                                                </td>
                                                                <td>COD</td>
                                                                <td><a href="#!"><i class="ri-eye-line"></i></a></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="fw-bolder">#1017</span></td>
                                                                <td>06 Jul 2024 03:15:PM
                                                                </td>
                                                                <td>$1.97</td>
                                                                <td>
                                                                    <div
                                                                        class="badge bg-pending custom-badge rounded-0">
                                                                        <span>Pending</span>
                                                                    </div>
                                                                </td>
                                                                <td>COD</td>
                                                                <td><a href="#!"><i class="ri-eye-line"></i></a></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="fw-bolder">#1016</span></td>
                                                                <td>26 Jun 2024 10:23:AM
                                                                </td>
                                                                <td>$46.14</td>
                                                                <td>
                                                                    <div
                                                                        class="badge bg-pending custom-badge rounded-0">
                                                                        <span>Pending</span>
                                                                    </div>
                                                                </td>
                                                                <td>COD</td>
                                                                <td><a href="#!"><i class="ri-eye-line"></i></a></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="fw-bolder">#1015</span></td>
                                                                <td>25 Jun 2024 06:34:PM
                                                                </td>
                                                                <td>$18.75</td>
                                                                <td>
                                                                    <div
                                                                        class="badge bg-pending custom-badge rounded-0">
                                                                        <span>Pending</span>
                                                                    </div>
                                                                </td>
                                                                <td>COD</td>
                                                                <td><a href="#!"><i class="ri-eye-line"></i></a></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="fw-bolder">#1013</span></td>
                                                                <td>24 Jun 2024 02:29:PM
                                                                </td>
                                                                <td>$1.72</td>
                                                                <td>
                                                                    <div
                                                                        class="badge bg-pending custom-badge rounded-0">
                                                                        <span>Pending</span>
                                                                    </div>
                                                                </td>
                                                                <td>COD</td>
                                                                <td><a href="#!"><i class="ri-eye-line"></i></a></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="fw-bolder">#1012</span></td>
                                                                <td>21 Jun 2024 05:18:PM
                                                                </td>
                                                                <td>$6.23</td>
                                                                <td>
                                                                    <div
                                                                        class="badge bg-pending custom-badge rounded-0">
                                                                        <span>Pending</span>
                                                                    </div>
                                                                </td>
                                                                <td>COD</td>
                                                                <td><a href="#!"><i class="ri-eye-line"></i></a></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="fw-bolder">#1011</span></td>
                                                                <td>21 Jun 2024 05:18:PM
                                                                </td>
                                                                <td>$39.72</td>
                                                                <td>
                                                                    <div
                                                                        class="badge bg-pending custom-badge rounded-0">
                                                                        <span>Pending</span>
                                                                    </div>
                                                                </td>
                                                                <td>COD</td>
                                                                <td><a href="#!"><i class="ri-eye-line"></i></a></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="fw-bolder">#1010</span></td>
                                                                <td>21 Jun 2024 04:29:PM
                                                                </td>
                                                                <td>$3.76</td>
                                                                <td>
                                                                    <div
                                                                        class="badge bg-pending custom-badge rounded-0">
                                                                        <span>Pending</span>
                                                                    </div>
                                                                </td>
                                                                <td>COD</td>
                                                                <td><a href="#!"><i class="ri-eye-line"></i></a></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="fw-bolder">#1009</span></td>
                                                                <td>21 Jun 2024 03:57:PM
                                                                </td>
                                                                <td>$1.52</td>
                                                                <td>
                                                                    <div
                                                                        class="badge bg-pending custom-badge rounded-0">
                                                                        <span>Pending</span>
                                                                    </div>
                                                                </td>
                                                                <td>COD</td>
                                                                <td><a href="#!"><i class="ri-eye-line"></i></a></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="fw-bolder">#1006</span></td>
                                                                <td>21 Jun 2024 03:48:PM
                                                                </td>
                                                                <td>$5.49</td>
                                                                <td>
                                                                    <div
                                                                        class="badge bg-pending custom-badge rounded-0">
                                                                        <span>Pending</span>
                                                                    </div>
                                                                </td>
                                                                <td>COD</td>
                                                                <td><a href="#!"><i class="ri-eye-line"></i></a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="product-pagination">
                                                <div class="theme-paggination-block">
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

                        <div class="tab-pane fade" id="refund-tab-pane" role="tabpanel">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mb-0 dashboard-table mt-0">
                                        <div class="card-body">
                                            <div class="top-sec">
                                                <h3>Refund</h3>
                                            </div>
                                            <div class="total-box mt-0">
                                                <div class="wallet-table mt-0">
                                                    <div class="table-responsive">
                                                        <table class="table cart-table order-table">
                                                            <thead>
                                                                <tr class="table-head">
                                                                    <th>Order</th>
                                                                    <th>Status</th>
                                                                    <th class="reason-table">Reason</th>
                                                                    <th>Created At</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><span class="fw-bolder">#1000</span></td>
                                                                    <td>
                                                                        <div class="status-rejected">
                                                                            <span>Rejected</span>
                                                                        </div>
                                                                    </td>
                                                                    <td class="reason-table">Item was damaged . also
                                                                        fabric was not
                                                                        good as expected</td>
                                                                    <td>21 Jun 2024</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="product-pagination">
                                                    <div class="theme-paggination-block">
                                                        <nav>
                                                            <ul class="pagination">
                                                                <li class="page-item">
                                                                    <a class="page-link" href="#!"
                                                                        aria-label="Previous">
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
                        </div>
                        <div class="tab-pane fade" id="address-tab-pane" role="tabpanel">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mb-0 mt-0">
                                        <div class="card-body">
                                            <div class="top-sec">
                                                <h3>Address Book</h3><a href="#add-address" data-bs-toggle="modal" class="btn btn-sm btn-solid">+ Add New</a>
                                            </div>
                                            <div class="address-book-section">
                                                <div class="row g-4">
                                                    <div class="select-box active col-xl-4 col-md-6">
                                                        <div class="address-box">
                                                            <div class="top">
                                                                <h6>John Due <span>New Home</span></h6>
                                                            </div>
                                                            <div class="middle">
                                                                <div class="address">
                                                                    <p>26, Starts Hollow Colony, Denver</p>
                                                                    <p>Colorado, United States</p>
                                                                    <p>80014</p>
                                                                </div>
                                                                <div class="number">
                                                                    <p>Phone: <span>+1 5551855359</span></p>
                                                                </div>
                                                            </div>
                                                            <div class="bottom"><a href="#edit-address" data-bs-toggle="modal" class="bottom_btn">Edit</a><a href="#delate-address" data-bs-toggle="modal" class="bottom_btn">Remove</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="select-box active col-xl-4 col-md-6">
                                                        <div class="address-box">
                                                            <div class="top">
                                                                <h6>John Due <span>Old Home</span>
                                                                </h6>
                                                            </div>
                                                            <div class="middle">
                                                                <div class="address">
                                                                    <p>53B, Claire New Street, San Jose</p>
                                                                    <p>Colorado, United States</p>
                                                                    <p>94088</p>
                                                                </div>
                                                                <div class="number">
                                                                    <p>Phone: <span>+1 5551855359</span></p>
                                                                </div>
                                                            </div>
                                                            <div class="bottom"><a href="#edit-address" data-bs-toggle="modal" class="bottom_btn">Edit</a><a href="#delate-address" data-bs-toggle="modal" class="bottom_btn">Remove</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="select-box active col-xl-4 col-md-6">
                                                        <div class="address-box">
                                                            <div class="top">
                                                                <h6>John Due <span>Office</span></h6>
                                                            </div>
                                                            <div class="middle">
                                                                <div class="address">
                                                                    <p>21B, Row New Street, San Jose</p>
                                                                    <p>California, United States</p>
                                                                    <p>94088</p>
                                                                </div>
                                                                <div class="number"> <p>Phone: <span>+1 551865359</span></p></div>
                                                            </div>
                                                            <div class="bottom"><a href="#edit-address" data-bs-toggle="modal" class="bottom_btn">Edit</a><a href="#delate-address" data-bs-toggle="modal" class="bottom_btn">Remove</a></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  dashboard section end -->

@endsection
