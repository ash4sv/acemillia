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
    <script src="{!! asset('assets/js/aces-news-feed.js') !!}"></script>
    <script>
        $(function() {
            $('#avatarBtn').on('click', function() {
                $('#avatarInput').click();
            });

            $('#avatarInput').on('change', function() {
                const file = this.files[0];
                if (!file) return;

                const ext = file.name.split('.').pop().toLowerCase();
                const validExts = ['jpg','jpeg','png'];
                if ($.inArray(ext, validExts) === -1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid format',
                        text: 'Only .jpg, .jpeg or .png files are allowed.'
                    });
                    $(this).val('');
                    return;
                }

                if (file.size > 1048576) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File too large',
                        text: 'Please choose an image under 1 MB.'
                    });
                    $(this).val('');
                    return;
                }

                const reader = new FileReader();
                reader.onload = e => {
                    const img = new Image();
                    img.onload = () => {
                        const targetSize = 150;
                        const minDim = Math.min(img.width, img.height);
                        const sx = (img.width - minDim) / 2;
                        const sy = (img.height - minDim) / 2;

                        const cropCanvas = document.createElement('canvas');
                        cropCanvas.width = targetSize;
                        cropCanvas.height = targetSize;
                        const cx = cropCanvas.getContext('2d');
                        cx.drawImage(img, sx, sy, minDim, minDim, 0, 0, targetSize, targetSize);

                        const finalSize = targetSize * 0.8; // 80% of 150px = 120px
                        const finalCanvas = document.createElement('canvas');
                        finalCanvas.width = finalSize;
                        finalCanvas.height = finalSize;
                        const fx = finalCanvas.getContext('2d');
                        fx.drawImage(cropCanvas, 0, 0, targetSize, targetSize, 0, 0, finalSize, finalSize);

                        const dataUrl = finalCanvas.toDataURL('image/png');
                        $('#avatarPreview').html(`<img src="${dataUrl}" alt="Avatar preview">`);
                        $('#avatarBtn').text('Change Image');
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });

            $.validator.addMethod('filesize', function(_, element, maxBytes) {
                if (!element.files.length) return true;
                return element.files[0].size <= maxBytes;
            }, 'File must be smaller than 1 MB.');

            $('.form').validate({
                rules: {
                    avatar: {
                        extension: 'jpg|jpeg|png',
                        filesize: 1048576
                    }
                },
                messages: {
                    avatar: {
                        extension: 'Only .jpg/.jpeg/.png are allowed.',
                        filesize: 'File must be under 1 MB.'
                    }
                },
                errorPlacement() {
                    // no-op
                },
                invalidHandler(_, validator) {
                    if (validator.errorList.length) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid file',
                            text: validator.errorList[0].message
                        });
                    }
                }
            });
        });

    </script>
@endpush

@section('webpage')

    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <h2>@yield('title')</h2>
            <nav class="theme-breadcrumb">
                <ol class="breadcrumb">
                    @foreach ($breadcrumbs ?? [] as $breadcrumb)
                        <li class="breadcrumb-item">
                            @if (!empty($breadcrumb['url']))
                                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                            @else
                                {{ $breadcrumb['label'] }}
                            @endif
                        </li>
                    @endforeach
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
                        @userrole
                        <div class="profile-top">
                            <div class="profile-top-box">
                                <div class="profile-image">
                                    <div class="position-relative">
                                        @isset($authUser->icon_avatar)
                                        <div class="user-round">
                                            <h4 class="text-center">{!! $authUser->icon_avatar !!}</h4>
                                        </div>
                                        @endisset
                                        @isset($authUser->img_avatar)
                                        <div class="user-icon">
                                            <input type="file" accept="image/*" name="avatar">
                                            <i class="ri-image-edit-line d-lg-block d-none"></i>
                                            <i class="ri-pencil-fill edit-icon d-lg-none"></i>
                                        </div>
                                        @endisset
                                    </div>
                                </div>
                            </div>
                            <div class="profile-detail">
                                <h5>{{ Str::limit($authUser->name, 17, '...') }}</h5>
                                <h6>{{ $authUser->email }}</h6>
                            </div>
                        </div>
                        @enduserrole
                        @merchantrole
                        <div class="profile-top">
                            <div class="profile-image vendor-image">
                                <img src="{!! asset('assets/images/logos/17.png') !!}" alt="" class="img-fluid">
                            </div>
                            <div class="profile-detail">
                                <h5>{!! Str::limit($authUser->company_name, 17, '...') !!}</h5>
                                {{--<h6>750 followers | 10 review</h6>--}}
                                <h6>{!! $authUser->email !!}</h6>
                            </div>
                        </div>
                        @endmerchantrole
                        <div class="faq-tab">
                            @userrole
                            @include(__('apps.layouts.shop-user-aside'))
                            @enduserrole
                            @merchantrole
                            @include(__('apps.layouts.shop-merchant-aside'))
                            @endmerchantrole
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <button class="show-btn btn d-lg-none d-block">Show Menu</button>
                    <div class="faq-content tab-content" id="myTabContent">
                        @yield('user-apps-content')


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

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  dashboard section end -->

@endsection
