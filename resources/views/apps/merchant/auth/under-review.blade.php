@extends('apps.layouts.shop')

@php
    $title = 'Account is under review';
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
            <h2>@yield('title')</h2>
            <nav class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{!! url('/') !!}">{!! __('Home') !!}</a>
                    </li>
                    <li class="breadcrumb-item active">{!! strtoupper(__($title)) !!}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!--section start-->
    <section class="login-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto right-login text-center">
                    <h3>{!! $title !!}</h3>
                    <div class="theme-card authentication-right">
                        <p class="mb-0">{!! __('Your account is under review. Purchase features are not available until approved.') !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->

@endsection
