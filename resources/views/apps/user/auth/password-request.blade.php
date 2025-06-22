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
        <div class="container">
            <div class="row">
                <div class="col-lg-6 m-auto">
                    <h3 class="text-center">{!! __($title) !!}</h3>
                    <div class="theme-card authentication-right">
                        <form class="theme-form" action="{{ route('auth.password.request') }}" method="POST">
                            @csrf
                            <div class="form-box">
                                <label for="" class="form-label">{!! __('Email') !!}</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter Your Email" required="">
                            </div>
                            <button type="submit" class="btn btn-solid w-auto">{!! __('Submit') !!}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->

@endsection
