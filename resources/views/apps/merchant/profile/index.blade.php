@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-box">
        <div class="dashboard-title">
            <h4>{!! __('Profile') !!}</h4>
            <a class="ms-auto" href="{!! route('merchant.dashboard', ['section' => 'profile-edit']) !!}"><span>{!! __('Edit') !!}</span></a>
            <a class="ms-4" href="{!! route('merchant.dashboard', ['section' => 'password-edit']) !!}"><span>{!! __('Edit Password') !!}</span></a>
        </div>
        <div class="dashboard-detail">
            <div class="row g-3">
                <div class="col-md-3">{!! __('Company name') !!}</div>
                <div class="col-md-9">{!! $authUser->company_name !!}</div>

                <div class="col-md-3">{!! __('Company registration number') !!}</div>
                <div class="col-md-9">{!! $authUser->company_registration_number !!}</div>

                <div class="col-md-3">{!! __('Tax ID') !!}</div>
                <div class="col-md-9">{!! $authUser->tax_id !!}</div>

                <div class="col-md-3">{!! __(' Business License ') !!}</div>
                <div class="col-md-9"><a href="{!! asset($authUser->business_license_document) !!}" target="_blank">{!! __('View Document') !!}</a></div>

                <div class="col-md-3">{!! __('Bank Name Account') !!}</div>
                <div class="col-md-9">{!! $authUser->bank_name_account !!}</div>

                <div class="col-md-3">{!! __('Bank Account Details') !!}</div>
                <div class="col-md-9">{!! $authUser->bank_account_details !!}</div>

                <div class="col-md-3">{!! __('Contact person name') !!}</div>
                <div class="col-md-9">{!! $authUser->name !!}</div>

                <div class="col-md-3">{!! __('Product category') !!}</div>
                <div class="col-md-9">{!! $authUser->menuSetup?->name !!}</div>

                <div class="col-md-3">{!! __('Email address') !!}</div>
                <div class="col-md-9">{!! $authUser->email !!}</div>

                <div class="col-md-3">{!! __('Phone') !!}</div>
                <div class="col-md-9">{!! $authUser->phone !!}</div>
            </div>
        </div>
    </div>

@endsection
