@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-table">
        <div class="wallet-table">
            <div class="top-sec">
                <h3>orders</h3>
                {{--<a href="#!" class="btn btn-sm btn-solid">add product</a>--}}
            </div>
            <div class="table-responsive">
                <table class="table cart-table order-table">
                    <thead>
                    <tr>
                        <th>order id</th>
                        <th>product details</th>
                        <th>status</th>
                        <th>price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>#125021</td>
                        <td>neck velvet dress</td>
                        <td><span
                                class="badge bg-credit custom-badge rounded-0">shipped</span>
                        </td>
                        <td>$205</td>
                    </tr>
                    <tr>
                        <td>#521214</td>
                        <td>belted trench coat</td>
                        <td><span
                                class="badge bg-credit custom-badge rounded-0">shipped</span>
                        </td>
                        <td>$350</td>
                    </tr>
                    <tr>
                        <td>#521021</td>
                        <td>men print tee</td>
                        <td><span
                                class="badge bg-pending custom-badge rounded-0">pending</span>
                        </td>
                        <td>$150</td>
                    </tr>
                    <tr>
                        <td>#245021</td>
                        <td>woman print tee</td>
                        <td><span
                                class="badge bg-credit custom-badge rounded-0">shipped</span>
                        </td>
                        <td>$150</td>
                    </tr>
                    <tr>
                        <td>#122141</td>
                        <td>men print tee</td>
                        <td><span
                                class="badge bg-credit custom-badge rounded-0">shipped</span>
                        </td>
                        <td>$150</td>
                    </tr>
                    <tr>
                        <td>#125015</td>
                        <td>men print tee</td>
                        <td><span
                                class="badge bg-pending custom-badge rounded-0">pending</span>
                        </td>
                        <td>$150</td>
                    </tr>
                    <tr>
                        <td>#245021</td>
                        <td>woman print tee</td>
                        <td>
                                                        <span
                                                            class="badge bg-credit custom-badge rounded-0">shipped</span>
                        </td>
                        <td>$150</td>
                    </tr>
                    <tr>
                        <td>#122141</td>
                        <td>men print tee</td>
                        <td><span
                                class="badge bg-debit custom-badge rounded-0">cancelled</span>
                        </td>
                        <td>$150</td>
                    </tr>
                    <tr>
                        <td>#125015</td>
                        <td>men print tee</td>
                        <td><span
                                class="badge bg-pending custom-badge rounded-0">pending</span>
                        </td>
                        <td>$150</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
