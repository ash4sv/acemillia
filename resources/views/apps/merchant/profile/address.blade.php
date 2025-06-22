@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-box">
        <div class="dashboard-title">
            <h4>{!! __('Address Edit') !!}</h4>
            <a class="ms-auto" href="{!! route('merchant.dashboard', ['section' => 'profile']) !!}"><span>{!! __('Back') !!}</span></a>
        </div>
        <div class="dashboard-detail">

            <div class="row">

                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="" class="form-label mb-1">{!! __('Business Address') !!}</label>
                        <input type="text" name="company_name" id="" value="{!! $authUser->address?->business_address !!}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="" class="form-label mb-1">{!! __('Country') !!}</label>
                        <input type="text" name="company_name" id="" value="{!! $authUser->address?->country !!}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="" class="form-label mb-1">{!! __('State') !!}</label>
                        <input type="text" name="company_name" id="" value="{!! $authUser->address?->state !!}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="" class="form-label mb-1">{!! __('City') !!}</label>
                        <input type="text" name="company_name" id="" value="{!! $authUser->address?->city !!}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="" class="form-label mb-1">{!! __('Street Address') !!}</label>
                        <input type="text" name="company_name" id="" value="{!! $authUser->address?->street_address !!}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="" class="form-label mb-1">{!! __('Postcode') !!}</label>
                        <input type="text" name="company_name" id="" value="{!! $authUser->address?->postcode !!}" class="form-control">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-sm btn-solid">{!! isset($authUser) ? 'Update' : '' !!} {!! __('Address') !!}</button>

        </div>
    </div>

@endsection
