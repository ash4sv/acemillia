@extends('apps.layouts.shop-user-layout')

@php
    $route = 'merchant.profile.';
@endphp

@section('user-apps-content')

    <div class="dashboard-box">
        <div class="dashboard-title">
            <h4>{!! __('Update Profile') !!}</h4>
            <a class="ms-auto" href="{!! route('merchant.dashboard', ['section' => 'profile']) !!}"><span>{!! __('Back') !!}</span></a>
        </div>
        <div class="dashboard-detail">
            <form action="{{ isset($authUser) ? route( $route . 'update', $authUser->id) : route( $route . 'store') }}" enctype="multipart/form-data" class="mb-0" method="POST">
                @csrf
                @if(isset($authUser))
                    @method('PUT')
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label mb-1">{!! __('Company Name') !!}</label>
                            <input type="text" name="company_name" id="" value="{!! $authUser->company_name !!}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label mb-1">{!! __('Company Registration Number') !!}</label>
                            <input type="text" name="company_registration_number" id="" value="{!! $authUser->company_registration_number !!}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label mb-1">{!! __('Tax ID') !!}</label>
                            <input type="text" name="tax_id" id="" value="{!! $authUser->tax_id !!}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label mb-1">{!! __('Business License') !!}</label>
                            <div class="input-group">
                                <input type="file" name="business_license_document" id="" value="{!! $authUser->business_license_document !!}" class="form-control">
                                <a href="{!! asset($authUser->business_license_document) !!}" class="btn btn-sm btn-solid" target="_blank">{!! __('View') !!}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label mb-1">{!! __('Bank Name Account') !!}</label>
                            <input type="text" name="bank_name_account" id="" value="{!! $authUser->bank_name_account !!}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label mb-1">{!! __('Bank Account Details') !!}</label>
                            <input type="text" name="bank_account_details" id="" value="{!! $authUser->bank_account_details !!}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="" class="form-label mb-1">{!! __('Contact Person Name') !!}</label>
                            <input type="text" name="name" id="" value="{!! $authUser->name !!}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="" class="form-label mb-1">{!! __('Product Category') !!}</label>
                            <input type="text" name="product_categories" id="" value="{!! $authUser->menuSetup?->name !!}" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label mb-1">{!! __('Email') !!}</label>
                            <input type="text" name="email" id="" value="{!! $authUser->email !!}" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label mb-1">{!! __('Phone') !!}</label>
                            <input type="text" name="phone" id="" value="{!! $authUser->phone !!}" class="form-control">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-solid">{!! isset($authUser) ? 'Update' : '' !!} {!! __('Profile') !!}</button>
            </form>
        </div>
    </div>

@endsection
