@extends('apps.layouts.shop')

@php
    $title = 'Compare';
    $description = '';
    $keywords = '';
    $author = '';
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
            <h2>{!! __($title) !!}</h2>
            <nav class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{!! url('/') !!}">{!! __('Home') !!}</a>
                    </li>
                    @if(auth()->guard('web')->check())
                    <li class="breadcrumb-item">
                        <a href="{!! route('dashboard') !!}">{!! __('Dashboard') !!}</a>
                    </li>
                    @endif
                    <li class="breadcrumb-item active">{!! __($title) !!}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb End -->

    <!-- section start -->
    <section class="compare-padding">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="compare-page">
                        @php
                            use \App\Models\User\Compare;
                            $maxCols = Compare::MAX_ITEMS;      // = 5
                            $colspan = max($products->count(), 1); // avoid 0 cols when list is empty
                            $cellWidth = "calc((100% - 200px) / {$maxCols})";
                        @endphp
                        @if ($products->isEmpty())
                            <div class="table-wrapper table-responsive">
                                <table class="table compare-table">
                                    <tbody>
                                    <tr>
                                        <td colspan="6">
                                            <div class="d-flex align-items-center justify-content-center" style="min-height:10rem;">
                                                <h3 class="m-0 text-center fw-lighter">
                                                    No products in compare list yet.
                                                </h3>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="table-wrapper table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr class="th-compare">
                                        <td>Action</td>
                                        @foreach ($products as $product)
                                        <th class="item-row">
                                            <form action="{{ route('compare.destroy', $product->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="remove-compare">Remove</button>
                                            </form>
                                        </th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody id="table-compare">
                                    <tr>
                                        <th class="product-name">Product Name</th>
                                        @foreach ($products as $product)
                                        <td class="grid-link__title">{{ Str::limit($product->name, 100) }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <th class="product-name">Product Image</th>
                                        @foreach ($products as $product)
                                            @php
                                                $category = $product->categories->first();
                                            @endphp
                                        <td class="item-row">
                                            <img src="{{ asset($product->image) }}" alt="" class="featured-image">
                                            <div class="product-price product_price">
                                                {{--<strong>On Sale: </strong><span>$89,00</span>--}}
                                                <h4 class="mb-0">{{ $product->price }}</h4>
                                            </div>
                                            <form class="variants clearfix mb-1">
                                                <input type="hidden">
                                                <button title="Add to Cart" class="add-to-cart btn btn-solid">Add to Cart</button>
                                            </form>
                                            @if ($category)
                                                <p class="grid-link__title hidde mb-1">{{ $category->name }}</p>
                                            @endif
                                            @foreach ($product->sub_categories as $sub)
                                                <p class="grid-link__title hidden mb-1">{{ $sub->name }}</p>
                                            @endforeach
                                        </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <th class="product-name">Product Description</th>
                                        @foreach ($products as $product)
                                        <td class="item-row">
                                            {!! Str::limit($product->product_description, 200)  !!}
                                        </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <th class="product-name">Availability</th>
                                        @foreach ($products as $product)
                                        <td class="available-stock">
                                            <p>Available In stock</p>
                                        </td>
                                        @endforeach
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->

@endsection
