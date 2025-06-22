@extends('apps.layouts.app-auth')

@section('title', 'Admin sign in instead')
@section('description', '')
@section('keywords', '')

@push('style') @endpush

@push('script') @endpush

@section('auth_content')

   <!-- Login -->
    <div class="card">
        <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center mb-2 mt-2">
                <a href="{{ url('/') }}" class="app-brand-link gap-2">
                    <img src="{{ asset('assets/images/logo-neuraloka_black.png') }}" alt="" class="img-fluid d-block" style="height:80px;">
                </a>
            </div>
            <!-- /Logo -->

            <h4 class="mb-1 pt-2 text-center">{{ __('ProdifyX e-Commerce') }}</h4>
            <p class="mb-4 text-center">{{ __('Make your app management easy and fun!') }}</p>

            <form id="formAuthentication" class="mb-3" action="{{ route(__('admin.auth.login')) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your email or username" autofocus>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 form-password-toggle">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="password">{{ __('Password') }}</label>
                        <a href="{{ route( 'admin.auth.password.request') }}">
                            <small>{{ __('Forgot Password?') }}</small>
                        </a>
                    </div>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember-me">
                        <label class="form-check-label" for="remember-me">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary d-grid w-100" type="submit">{{ __('Sign in') }}</button>
                </div>
            </form>

            <p class="text-center">
                <span>{{ __('New on our platform?') }}</span>
                <a href="{{ route('admin.register') }}">
                    <span>{{ __('Create an account') }}</span>
                </a>
            </p>

            {{--<div class="divider my-4">
                <div class="divider-text">or</div>
            </div>--}}

            {{--<div class="d-flex justify-content-center">
                <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
                    <i class="tf-icons fa-brands fa-facebook-f fs-5"></i>
                </a>

                <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
                    <i class="tf-icons fa-brands fa-google fs-5"></i>
                </a>

                <a href="javascript:;" class="btn btn-icon btn-label-twitter">
                    <i class="tf-icons fa-brands fa-twitter fs-5"></i>
                </a>
            </div>--}}

            <p class="mt-4 pb-0 mb-0 text-center">Developed by Ardia Nexus Sdn. Bhd.</p>
        </div>
    </div>
    <!-- Login -->

@endsection
