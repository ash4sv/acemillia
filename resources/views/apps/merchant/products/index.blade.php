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
                        <th>Image</th>
                        <th>Product name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Sales</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $key => $product)
                    <tr>
                        <td class="image-box py-2">
                            <img src="{!! asset($product->image) !!}" alt="" class="blur-up lazyloaded">
                        </td>
                        <td>{!! $product->name !!}</td>
                        <td class="text-theme">{!! $product->price !!}</td>
                        <td>{!! $product->total_stock !!}</td>
                        <td>2000</td>
                        <td class="py-2">
                            <div class="dropdown">
                                <button class="btn btn-info text-white dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu w-100">
                                    <li class="w-100"><a class="dropdown-item" href="{!! route('merchant.products.show', $product->id) !!}"><i class="fa fa-eye me-1"></i> {!! __('View') !!}</a></li>
                                    <li class="w-100"><a class="dropdown-item" href="{!! route('merchant.products.edit', $product->id) !!}"><i class="fa fa-pencil-square-o"></i> {!! __('Edit') !!}</a></li>
                                    <li class="w-100"><a class="dropdown-item" href="{!! route('merchant.products.destroy', $product->id) !!}" data-confirm-delete="true"><i class="fa fa-trash-o"></i> {!! __('Delete') !!}</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
