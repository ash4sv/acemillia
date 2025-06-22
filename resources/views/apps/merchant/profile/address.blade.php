@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-box">
        <div class="dashboard-title">
            <h4>{!! __('Address Edit') !!}</h4>
            <a class="ms-auto" href="{!! route('merchant.dashboard', ['section' => 'profile']) !!}"><span>{!! __('Back') !!}</span></a>
        </div>
        <div class="dashboard-detail">

            <form action="{{ route('merchant.address.update') }}" method="POST">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="business_address" class="form-label mb-1">{!! __('Business Address') !!}</label>
                            <input type="text" name="business_address" id="business_address" value="{!! $authUser->address?->business_address !!}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="country" class="form-label mb-1">{!! __('Country') !!}</label>
                            <input type="text" name="country" id="country" value="{!! $authUser->address?->country !!}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="state" class="form-label mb-1">{!! __('State') !!}</label>
                            <input type="text" name="state" id="state" value="{!! $authUser->address?->state !!}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="city" class="form-label mb-1">{!! __('City') !!}</label>
                            <input type="text" name="city" id="city" value="{!! $authUser->address?->city !!}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="street_address" class="form-label mb-1">{!! __('Street Address') !!}</label>
                            <input type="text" name="street_address" id="street_address" value="{!! $authUser->address?->street_address !!}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="postcode" class="form-label mb-1">{!! __('Postcode') !!}</label>
                            <input type="text" name="postcode" id="postcode" value="{!! $authUser->address?->postcode !!}" class="form-control">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-solid">{!! isset($authUser) ? 'Update' : '' !!} {!! __('Address') !!}</button>
            </form>

        </div>
    </div>

@endsection
