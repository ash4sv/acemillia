@extends('apps.layouts.shop')

@php
    $title = 'Verify your email';
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
                    <h3>{!! __($title) !!}</h3>
                    <div class="theme-card authentication-right">
                        <p class="mb-4">{!! __('Account activation link sent to your email address:') !!} <span class="text-primary">{{ __($email) }}</span> {!! __('Please follow the link inside to continue.') !!}</p>
                        <a href="javascript:void(0);" onclick="$('#verificationResend').submit()" class="btn btn-solid">{!! __('Resend') !!}</a>
                    </div>
                    <form id="verificationResend" class="d-none" method="POST" action="{{ route('merchant.verification.resend') }}">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->

@endsection
