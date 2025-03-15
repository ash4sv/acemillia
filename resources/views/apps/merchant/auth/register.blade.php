@extends('apps.layouts.shop')

@php
    $title = 'Merchant create account';
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
<script>
$(document).ready(function(){

    window.selectedState = '{{ $addressBook->state ?? '' }}';
    window.selectedCity = '{{ $addressBook->city ?? '' }}';
    window.selectedStreet = '{{ $addressBook->street_address ?? '' }}';
    window.selectedPostcode = '{{ $addressBook->postcode ?? '' }}';

    // Assume these variables are provided in edit mode (or set to null for new entries)
    var selectedState = window.selectedState || null;
    var selectedCity = window.selectedCity || null;
    var selectedStreet = window.selectedStreet || null;
    var selectedPostcode = window.selectedPostcode || null;

    // Populate states dropdown
    $.ajax({
        url: '/user/countries',
        method: 'GET',
        success: function(countries) {
            var $nationalitySelect = $('#nationalityDropdown');
            $nationalitySelect.empty().append('<option value="">Please select</option>');
            $.each(countries, function(index, country) {
                // Use alpha_2_code as the option value, and en_short_name as the display text.
                $nationalitySelect.append('<option value="'+ country.alpha_2_code +'">'+ country.en_short_name +'</option>');
            });
        },
        error: function(err) {
            console.log('Error fetching countries:', err);
        }
    });

    // Populate states dropdown
    $.ajax({
        url: '/user/states',
        method: 'GET',
        success: function(states) {
            $('#stateDropdown').empty().append('<option value="">Select State</option>');
            $.each(states, function(index, state) {
                var selected = (selectedState && selectedState === state.value) ? ' selected' : '';
                $('#stateDropdown').append('<option value="'+ state.value +'"'+ selected+'>'+ state.name +'</option>');
            });
            // Trigger change if edit mode
            if(selectedState) {
                $('#stateDropdown').trigger('change');
            }
        }
    });

    // When state is selected, populate cities dropdown
    $('#stateDropdown').on('change', function(){
        var state = $(this).val();
        $('#cityDropdown, #streetDropdown, #postcodeDropdown').empty();
        if(state) {
            $.ajax({
                url: '/user/cities',
                method: 'GET',
                data: { state: state },
                success: function(cities) {
                    $('#cityDropdown').append('<option value="">Select City</option>');
                    $.each(cities, function(index, city) {
                        var selected = (selectedCity && selectedCity === city.value) ? ' selected' : '';
                        $('#cityDropdown').append('<option value="'+ city.value +'"'+ selected+'>'+ city.name +'</option>');
                    });
                    if(selectedCity) {
                        $('#cityDropdown').trigger('change');
                    }
                }
            });
        }
    });

    // When city is selected, populate streets dropdown
    $('#cityDropdown').on('change', function(){
        var state = $('#stateDropdown').val();
        var city = $(this).val();
        $('#streetDropdown, #postcodeDropdown').empty();
        if(state && city) {
            $.ajax({
                url: '/user/streets',
                method: 'GET',
                data: { state: state, city: city },
                success: function(streets) {
                    $('#streetDropdown').append('<option value="">Select Street</option>');
                    $.each(streets, function(index, street) {
                        var selected = (selectedStreet && selectedStreet === street.value) ? ' selected' : '';
                        $('#streetDropdown').append('<option value="'+ street.value +'"'+ selected+'>'+ street.name +'</option>');
                    });
                    if(selectedStreet) {
                        $('#streetDropdown').trigger('change');
                    }
                }
            });
        }
    });

    // When street is selected, populate postcodes dropdown
    $('#streetDropdown').on('change', function(){
        var state = $('#stateDropdown').val();
        var city = $('#cityDropdown').val();
        var street = $(this).val();
        $('#postcodeDropdown').empty();
        if(state && city && street) {
            $.ajax({
                url: '/user/postcodes',
                method: 'GET',
                data: { state: state, city: city, street: street },
                success: function(postcodes) {
                    $('#postcodeDropdown').append('<option value="">Select Postcode</option>');
                    $.each(postcodes, function(index, postcode) {
                        var selected = (selectedPostcode && selectedPostcode === postcode.value) ? ' selected' : '';
                        $('#postcodeDropdown').append('<option value="'+ postcode.value +'"'+ selected+'>'+ postcode.name +'</option>');
                    });
                }
            });
        }
    });
});
</script>
@endpush

@section('webpage')

    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <h2>@yield('title')</h2>
            <nav class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{!! url('/') !!}">{!! __('Home') !!}</a>
                    </li>
                    <li class="breadcrumb-item active">{!! strtoupper($title) !!}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!--section start-->
    <section class="login-page section-b-space">
        <div class="container">
            <h3>{!! $title !!}</h3>
            <div class="theme-card">
                <form class="theme-form" action="{{ route('merchant.auth.register') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="company_name" class="form-label">{!! __('Company Name') !!}</label>
                                <input type="text" class="form-control mb-0 @error('company_name') is-invalid @enderror" id="" name="company_name" placeholder="Company Name" value="{!! old('company_name') !!}">
                                @error('company_name')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="company_registration_number" class="form-label">{!! __('Company Registration Number') !!}</label>
                                <input type="text" class="form-control mb-0 @error('company_registration_number') is-invalid @enderror" id="" name="company_registration_number" placeholder="Company Registration Number" value="{!! old('company_registration_number') !!}">
                                <div class="form-text pt-1 text-secondary">
                                    {!! __('SSM registration Number') !!}
                                </div>
                                @error('company_registration_number')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="tax_id" class="form-label">{!! __('Tax ID') !!}</label>
                                <input type="text" class="form-control mb-0 @error('tax_id') is-invalid @enderror" id="" name="tax_id" placeholder="Tax ID" value="{!! old('tax_id') !!}">
                                @error('tax_id')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="business_license_document" class="form-label">{!! __('Business License') !!}</label>
                                <input type="file" class="form-control mb-0 @error('business_license_document') is-invalid @enderror" id="" name="business_license_document" placeholder="Business License" value="{!! old('business_license_document') !!}">
                                <div class="form-text pt-1 text-secondary">
                                    {!! __('(SSM registration). File support pdf, jpg, jpeg, and png') !!}
                                </div>
                                @error('business_license_document')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="contact_person_name" class="form-label">{!! __('Contact Person Name') !!}</label>
                                <input type="text" class="form-control mb-0 @error('contact_person_name') is-invalid @enderror" id="" name="contact_person_name" placeholder="Contact Person Name" value="{!! old('contact_person_name') !!}">
                                @error('contact_person_name')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-box">
                                <label for="business_address" class="form-label">{!! __('Business Address') !!}</label>
                                <input type="text" class="form-control mb-0 @error('business_address') is-invalid @enderror" id="" name="business_address" placeholder="Business Address" value="{!! old('business_address') !!}">
                                @error('business_address')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-box">
                                <label class="form-label">{!! __('State') !!}</label>
                                <select name="state" id="stateDropdown" class="form-select @error('state') is-invalid @enderror"></select>
                                @error('state')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-box">
                                <label for="city" class="form-label">{!! __('City') !!}</label>
                                <select name="city" id="cityDropdown" class="form-select @error('city') is-invalid @enderror"></select>
                                @error('city')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-box">
                                <label for="street_address" class="form-label">{!! __('Street') !!}</label>
                                <select name="street_address" id="streetDropdown" class="form-select @error('street_address') is-invalid @enderror"></select>
                                @error('street_address')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-box">
                                <label for="postcode" class="form-label">{!! __('Postcode') !!}</label>
                                <select name="postcode" id="postcodeDropdown" class="form-select @error('postcode') is-invalid @enderror"></select>
                                @error('postcode')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="bank_name_account" class="form-label">{!! __('Bank Name Account') !!}</label>
                                <input type="text" class="form-control mb-0 @error('bank_name_account') is-invalid @enderror" id="" name="bank_name_account" placeholder="Bank Name Account" value="{!! old('bank_name_account') !!}">
                                @error('bank_account_details')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="bank_account_details" class="form-label">{!! __('Bank Account Details') !!}</label>
                                <input type="text" class="form-control mb-0 @error('bank_account_details') is-invalid @enderror" id="" name="bank_account_details" placeholder="Bank Account Details" value="{!! old('bank_account_details') !!}">
                                @error('bank_account_details')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-box">
                                <label for="product_categories" class="form-label">{!! __('Product Categories') !!}</label>
                                <select name="product_categories" id="" class="form-select">
                                    <option value="">Please select</option>
                                    @foreach($menus as $key => $menu)
                                    <option value="{!! $menu->id !!}">{!! $menu->name !!}</option>
                                    @endforeach
                                </select>
                                @error('product_categories')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="email" class="form-label">{!! __('Email') !!}</label>
                                <input type="email" class="form-control mb-0 @error('email') is-invalid @enderror" id="" name="email" placeholder="Email" value="{!! old('email') !!}">
                                @error('email')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="phone" class="form-label">{!! __('Phone') !!}</label>
                                <input type="text" class="form-control mb-0 @error('phone') is-invalid @enderror" id="" name="phone" placeholder="Phone" value="{!! old('phone') !!}">
                                @error('phone')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="password" class="form-label">{!! __('Password') !!}</label>
                                <input type="password" class="form-control mb-0 @error('password') is-invalid @enderror" id="" name="password" placeholder="Enter your password" value="{!! old('password') !!}">
                                @error('password')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="password_confirmation" class="form-label">{!! __('Confirmation Password') !!}</label>
                                <input type="password" class="form-control mb-0 @error('password_confirmation') is-invalid @enderror" id="" name="password_confirmation" placeholder="Re-enter your password" value="{!! old('password_confirmation') !!}">
                                @error('password_confirmation')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-solid w-auto">{!! __('Create Account') !!}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--Section ends-->

@endsection
