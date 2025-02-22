@extends('apps.layouts.shop')

@php
    $title = 'Merchant create account';
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
                        <a href="{!! url('/') !!}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">{!! strtoupper($title) !!}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!--section start-->
    <section class="login-page section-b-space">
        <div class="container">
            <h3>{!! $title !!}</h3>
            <div class="theme-card">
                <form class="theme-form" action="{{ route('merchant.auth.register') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="email" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="" name="name" placeholder="Full Name" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="email" class="form-label">email</label>
                                <input type="email" class="form-control" id="" name="email" placeholder="Email" required="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="review" class="form-label">Password</label>
                                <input type="password" class="form-control" id="" name="password" placeholder="Enter your password" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="review" class="form-label">Confirmation Password</label>
                                <input type="password" class="form-control" id="" name="password_confirmation" placeholder="Re-enter your password" required="">
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-solid w-auto">create Account</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--Section ends-->

@endsection
