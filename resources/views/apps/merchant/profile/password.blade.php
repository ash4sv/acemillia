@extends('apps.layouts.shop-user-layout')

@php
    $route = 'merchant.password.';
@endphp

@section('user-apps-content')

    <div class="dashboard-box">
        <div class="dashboard-title">
            <h4>{!! __('Edit Password') !!}</h4>
            <a class="ms-auto" href="{!! route('merchant.dashboard', ['section' => 'profile']) !!}"><span>{!! __('Back') !!}</span></a>
        </div>
        <div class="dashboard-detail">

            <form action="{!! route( $route . 'update') !!}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="current_password" class="form-label mb-1">{!! __('Current Password') !!}</label>
                    <input type="password" name="current_password" id="current_password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label mb-1">{!! __('New Password') !!}</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label mb-1">{!! __('New Password Confirmation') !!}</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>
                <button type="submit" class="btn btn-sm btn-solid">{!! __('Submit') !!}</button>
            </form>

        </div>
    </div>

@endsection
