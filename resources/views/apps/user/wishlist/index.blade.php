@extends('apps.layouts.shop')

@php
    $title = 'Wishlist';
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

    <!--section start-->
    <section class="wishlist-section section-b-space">
        <div class="container">
            <div class="table-responsive">
                <table class="table cart-table">
                    <thead>
                    <tr class="table-head">
                        <th>image</th>
                        <th>product name</th>
                        <th>price</th>
                        <th>availability</th>
                        <th>action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <a href="product-page(accordian).html">
                                <img src="../assets/images/fashion-1/product/17.jpg" alt="">
                            </a>
                        </td>
                        <td><a href="product-page(accordian).html">Orange Coords Set</a>
                            <div class="mobile-cart-content row">
                                <div class="col">
                                    <p>in stock</p>
                                </div>
                                <div class="col">
                                    <h2 class="td-color">$9.96</h2>
                                </div>
                                <div class="col">
                                    <h2 class="td-color">
                                        <a href="#!" class="icon me-1">
                                            <i class="ri-close-line"></i>
                                        </a>
                                        <a href="#!" class="cart">
                                            <i class="ri-shopping-cart-line"></i>
                                        </a>
                                    </h2>
                                </div>
                            </div>
                        </td>
                        <td>
                            <h2>$9.96</h2>
                        </td>
                        <td>
                            <p>in stock</p>
                        </td>
                        <td>
                            <div class="icon-box d-flex gap-2 justify-content-center">
                                <a href="#!" class="icon me-1">
                                    <i class="ri-close-line"></i>
                                </a>
                                <a href="#!" class="cart">
                                    <i class="ri-shopping-cart-line"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="wishlist-buttons">
                <a href="{{ route('web.index') }}" class="btn btn-solid">{{ __('Continue Shopping') }}</a>
                <a href="{{ route('purchase.checkout') }}" class="btn btn-solid">{{ __('Check Out') }}</a>
            </div>
        </div>
    </section>
    <!--section end-->

@endsection
