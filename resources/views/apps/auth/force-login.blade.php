@extends('apps.layouts.shop')

@php
    $title = 'Login required';
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
                    @foreach ($breadcrumbs ?? [] as $breadcrumb)
                        <li class="breadcrumb-item">
                            @if (!empty($breadcrumb['url']))
                                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                            @else
                                {{ $breadcrumb['label'] }}
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!--section start-->
    <section class="login-page section-b-space">
        <div class="container pb-5">
            <div class="row">
                <div class="col-lg-4">
                    <h3>Customer Login</h3>
                    <div class="theme-card authentication-right">
                        <form class="theme-form" action="{{ route('auth.login') }}" method="POST">
                            @csrf
                            <div class="form-box">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Email" required="">
                            </div>
                            <div class="form-box">
                                <label for="review" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Enter your password" required="">
                            </div>
                            <div class="form-box mb-4">
                                <a href="{{ route('password.request') }}">Forget password?</a>
                            </div>
                            <button type="submit" class="btn btn-solid">Login</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h3>New Customer</h3>
                    <div class="theme-card authentication-right">
                        <h6 class="title-font">Create A Account</h6>
                        <p>Sign up for a free account at our store. Registration is quick and easy. It allows you to be able to order from our shop. To start shopping click register.</p>
                        <a href="{{ route('register') }}" class="btn btn-solid">Create an Account</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h3>Merchant Access</h3>
                    <div class="theme-card authentication-right">
                        <h6 class="title-font">Merchant Login</h6>
                        <p>Welcome back, valued partner! Log in to your ACEMILLIA Merchant Dashboard to:</p>
                        <ul class="ps-0 mb-4">
                            <li class="mb-2">Track & manage orders in real time</li>
                            <li class="mb-2">View performance insights & analytics</li>
                            <li>Access exclusive promotions</li>
                        </ul>
                        <a href="{{ route('merchant.login') }}" class="btn btn-primary w-100 mb-4">Merchant Login</a>

                        <h6 class="title-font">Merchant Registration</h6>
                        <p>Ready to grow with ACEMILLIA? Join our network to enjoy:</p>
                        <ul class="ps-0 mb-4">
                            <li class="mb-2">Seamless onboarding</li>
                            <li class="mb-2">Dedicated pharma-specialist support</li>
                            <li>Powerful marketing & data-driven tools</li>
                        </ul>
                        <a href="{{ route('merchant.register') }}" class="btn btn-success w-100">Create Merchant Account</a>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->

@endsection
