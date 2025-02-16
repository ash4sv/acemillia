@extends('apps.layouts.shop')

@php
    $title = 'Cart';
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
            <h2>{!! $title !!}</h2>
            <nav class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{!! url('/') !!}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">{!! __($title) !!}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb End -->

    <!--section start-->
    <section class="cart-section section-b-space">
        <div class="container">
            <!-- <div class="cart_counter">
                <div class="countdownholder">
                    Your cart will be expired in<span id="timer"></span> minutes!
                </div>
                <a href="checkout.html" class="cart_checkout btn btn-solid btn-xs">check out</a>
            </div> -->
            <div class="table-responsive">
                <table class="table cart-table">
                    <thead>
                        <tr class="table-head">
                            <th>Image</th>
                            <th>Product name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @forelse(cart()->all() as $key => $item)
                    <tr>
                        <td>
                            <a href="">
                                <img src="{{ asset($item->options->item_img) }}" class="img-fluid" alt="">
                            </a>
                        </td>
                        <td>
                            <a href="">{{ __($item->name) }}</a>
                            <div class="mobile-cart-content row">
                                <div class="col">
                                    <div class="qty-box">
                                        <div class="input-group qty-container">
                                            <button class="btn qty-btn-minus"><i class="ri-arrow-left-s-line"></i></button>
                                            <input type="text" readonly="" name="qty" class="form-control input-qty" value="{{ $item->quantity }}">
                                            <button class="btn qty-btn-plus"><i class="ri-arrow-right-s-line"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col table-price">
                                    <h2 class="td-color">{!! __('MYR' . number_format($item->price, 2)) !!}</h2>
                                </div>
                                <div class="col">
                                    <h2 class="td-color">
                                        <a href="" class="icon remove-btn">
                                            <i class="ri-close-line"></i>
                                        </a>
                                    </h2>
                                </div>
                            </div>
                        </td>
                        <td class="table-price">
                            <h2>{!! __('MYR' . number_format($item->price, 2)) !!}</h2>
                        </td>
                        <td>
                            <div class="qty-box">
                                <div class="input-group qty-container">
                                    <button class="btn qty-btn-minus"><i class="ri-arrow-left-s-line"></i></button>
                                    <input type="text" readonly="" name="qty" class="form-control input-qty" value="{{ $item->quantity }}">
                                    <button class="btn qty-btn-plus"><i class="ri-arrow-right-s-line"></i></button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <h2 class="td-color">{!! __('MYR' . number_format($item->quantity * $item->price, 2)) !!}</h2>
                        </td>
                        <td>
                            {{--<a href="" class="icon remove-btn">
                                <i class="ri-refresh-line"></i>
                            </a>--}}
                            <a href="#!" class="icon remove-btn" onclick="event.preventDefault(); document.getElementById('remove-cart-item-{{ $key }}-{{ $item->id }}').submit();">
                                <i class="ri-close-line"></i>
                            </a>
                            <form id="remove-cart-item-{{ $key }}-{{ __($item->id) }}" action="{{ route('purchase.remove-from-cart', ['id' => $item->id]) }}" method="POST">
                                @csrf
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6"></td>
                    </tr>
                    @endforelse
                    <tfoot>
                        <tr>
                            <td colspan="4" class="d-md-table-cell d-none">total price :</td>
                            <td class="d-md-none">total price :</td>
                            <td>
                                <h2>{!! __('MYR' . number_format(cart()->subtotal(), 2)) !!}</h2>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="row cart-buttons">
                <div class="col-6">
                    <a href="{{ url('/') }}" class="btn btn-solid text-capitalize">Continue Shopping</a>
                </div>
                <div class="col-6">
                    <a href="{{ route('purchase.checkout') }}" class="btn btn-solid text-capitalize">Check Out</a>
                </div>
            </div>
        </div>
    </section>
    <!--section end-->

@endsection
