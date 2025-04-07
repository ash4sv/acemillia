@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-table">
        <div class="wallet-table">
            <div class="top-sec">
                <h3>{!! __('All Products') !!}</h3>
                <a href="{!! route('merchant.dashboard', ['section' => 'product-create']) !!}" class="btn btn-sm btn-solid">{!! __('+ Add New') !!}</a>
            </div>
            <div class="table-responsive">
                <table class="table cart-table order-table">
                    <thead>
                    <tr>
                        <th>{!! __('Image') !!}</th>
                        <th>{!! __('Product name') !!}</th>
                        <th>{!! __('Price') !!}</th>
                        <th>{!! __('Stock') !!}</th>
                        <th>{!! __('Sales') !!}</th>
                        <th>{!! __('Action') !!}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($products as $key => $product)
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
                                <button class="btn btn-xs btn-solid text-white dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu w-100">
                                    <li class="w-100"><a class="dropdown-item" href="{!! route('merchant.products.show', $product->id) !!}">{!! __('View') !!}</a></li>
                                    <li class="w-100"><a class="dropdown-item" href="{!! route('merchant.products.edit', $product->id) !!}">{!! __('Edit') !!}</a></li>
                                    <li class="w-100"><a class="dropdown-item" href="{!! route('merchant.products.destroy', $product->id) !!}" data-confirm-delete="true">{!! __('Delete') !!}</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="d-flex align-items-center justify-content-center" style="min-height:10rem;">
                                <h3 class="m-0 text-center">
                                    Your shelves are empty - let’s stock them! Add your first product to start selling.
                                </h3>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {!! $products->links('apps.layouts.pagination-custom-user') !!}
        </div>
    </div>

@endsection
