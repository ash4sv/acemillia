@extends('apps.layouts.shop')

@php
    $title = 'Forgot password';
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
                <div class="col-lg-6 mx-auto right-login">
                    <h3 class="text-center">{!! __($title) !!}</h3>
                    <div class="theme-card authentication-right">
                        <form class="theme-form" action="{{ route('auth.password.reset') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $request->token }}">
                            <div class="form-box">
                                <label for="" class="form-label">Email</label>
                                <input class="form-control" type="email" id="email" name="email" readonly="" value="{{ $request->email }}">
                            </div>
                            <div class="form-box">
                                <label for="" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required="">
                            </div>
                            <div class="form-box">
                                <label for="" class="form-label">Password Confirmation</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required="">
                            </div>
                            <button type="submit" class="btn btn-solid w-auto">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->

@endsection
