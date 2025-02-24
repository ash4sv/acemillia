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

@endsection
