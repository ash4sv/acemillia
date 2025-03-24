@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-table">
        <div class="wallet-table">
            <div class="top-sec">
                <h3>All Products</h3>
                <a href="{!! route('merchant.dashboard', ['section' => 'product-create']) !!}" class="btn btn-sm btn-solid">+ Add New</a>
            </div>
            <div class="table-responsive">
                <table class="table cart-table order-table">
                    <thead>
                    <tr>
                        <th>image</th>
                        <th>product name</th>
                        <th>price</th>
                        <th>stock</th>
                        <th>sales</th>
                        <th>edit/delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="image-box">
                            <img src="{!! asset('assets/images/fashion-1/product/5.jpg') !!}" alt="" class="blur-up lazyloaded">
                        </td>
                        <td>neck velvet dress</td>
                        <td class="fw-bold text-theme">$205</td>
                        <td>1000</td>
                        <td>2000</td>
                        <td>
                            <a href="#!">
                                <i class="fa fa-pencil-square-o me-1"></i>
                            </a>
                            <a href="#!">
                                <i class="fa fa-trash-o ms-1 text-theme"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
