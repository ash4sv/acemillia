@extends('apps.layouts.shop')

@php
    $title = 'Payment failed';
    $description = '';
    $keywords = '';
    $author = '';
@endphp

@section('description', '')
@section('keywords', '')
@section('author', '')
@section('title', $title)

@push('style')
    <style>
        .super-size {
            font-size: 8rem;
        }
    </style>
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
                        <a href="{!! route('dashboard', ['section' => 'my-order']) !!}">{!! __('My Order') !!}</a>
                    </li>
                    @endif
                    <li class="breadcrumb-item active">{!! __($title) !!}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb End -->

    <!-- thank-you section start -->
    <section class="section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center pb-3">
                        <i class="fa fa-close fa-5x super-size text-danger"></i>
                    </div>
                    <div class="success-text pb-4">
                        <h2>{!! __('Payment failed') !!}</h2>
                        <p>{!! __('Payment is unsuccessfully') !!}</p>
                        <p class="font-weight-bold">{!! __('Transaction ID:') !!} {!! __('267676GHERT105467') !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->

@endsection
