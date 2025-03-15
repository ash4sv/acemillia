@php
    $route = 'admin.registered-user.merchants.';
@endphp

<form action="{{ isset($merchant) ? route( $route . 'update', $merchant->id) : route( $route . 'store') }}" enctype="multipart/form-data" class="mb-0" method="POST">
    @csrf
    @if(isset($merchant))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="" class="form-label">{!! __('Company Name') !!}</label>
        <input type="text" name="" id="" class="form-control" disabled value="{!! old('', $merchant->company_name ?? '') !!}">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">{!! __('Company Registration Number') !!}</label>
        <input type="text" name="" id="" class="form-control" disabled value="{!! old('', $merchant->company_registration_number ?? '') !!}">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">{!! __('Tax ID') !!}</label>
        <input type="text" name="" id="" class="form-control" disabled value="{!! old('', $merchant->tax_id ?? '') !!}">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">{!! __('Business License') !!}</label>
        <div class="input-group">
            <input type="text" name="" id="" class="form-control" disabled value="{!! old('', $merchant->business_license_document ?? '') !!}">
            <a href="{!! asset($merchant->business_license_document) !!}" class="btn btn-outline-secondary" target="_blank">View Document</a>
        </div>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">{!! __('Contact Person Name') !!}</label>
        <input type="text" name="" id="" class="form-control" disabled value="{!! old('', $merchant->name ?? '') !!}">
    </div>

    <div class="mb-3">
        <label for="" class="form-label">{!! __('Bank Name Account') !!}</label>
        <input type="text" name="" id="" class="form-control" disabled value="{!! old('', $merchant->bank_name_account ?? '') !!}">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">{!! __('Bank Account Details') !!}</label>
        <input type="text" name="" id="" class="form-control" disabled value="{!! old('', $merchant->bank_account_details ?? '') !!}">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">{!! __('Product Categories') !!}</label>
        <input type="text" name="" id="" class="form-control" disabled value="">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">{!! __('Email') !!}</label>
        <input type="text" name="" id="" class="form-control" disabled value="{!! old('', $merchant->email ?? '') !!}">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">{!! __('Phone') !!}</label>
        <input type="text" name="" id="" class="form-control" disabled value="{!! old('', $merchant->phone ?? '') !!}">
    </div>

    <div class="mb-3">
        {!! \App\Services\Publish::submissionBtn($merchant->status_submission ?? 'Pending') !!}
    </div>

    <div class="mb-0">
        <button type="submit" class="btn btn-primary">{{ isset($merchant) ? 'Update' : 'Create' }} Merchant</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
    </div>
</form>
