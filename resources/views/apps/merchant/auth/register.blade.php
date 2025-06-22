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
        // Pre-initialize static selectize elements.
        // (These calls convert the <select> into selectize instances)
        $('#stateDropdown, #cityDropdown, #streetDropdown, #postcodeDropdown, #productCategories').selectize({
            create: true,
            sortField: 'text',
        });

        // Retrieve any pre-selected values (if in edit mode)
        window.selectedState    = '{{ $addressBook->state ?? '' }}';
        window.selectedCity     = '{{ $addressBook->city ?? '' }}';
        window.selectedStreet   = '{{ $addressBook->street_address ?? '' }}';
        window.selectedPostcode = '{{ $addressBook->postcode ?? '' }}';

        var selectedState    = window.selectedState || null;
        var selectedCity     = window.selectedCity || null;
        var selectedStreet   = window.selectedStreet || null;
        var selectedPostcode = window.selectedPostcode || null;

        // Utility functions to load dependent data using selectize API

        function loadCities(state) {
            var cityInstance = $('#cityDropdown')[0].selectize;
            cityInstance.clearOptions();
            $.ajax({
                url: '/user/cities',
                method: 'GET',
                data: { state: state },
                success: function(cities) {
                    // Add a default option
                    cityInstance.addOption({value:"", text:"Select City"});
                    $.each(cities, function(index, city) {
                        cityInstance.addOption({value: city.value, text: city.name});
                    });
                    cityInstance.refreshOptions(false);
                    if(selectedCity) {
                        cityInstance.setValue(selectedCity);
                    }
                },
                error: function(err) {
                    console.log('Error fetching cities:', err);
                }
            });
        }

        function loadStreets(state, city) {
            var streetInstance = $('#streetDropdown')[0].selectize;
            streetInstance.clearOptions();
            $.ajax({
                url: '/user/streets',
                method: 'GET',
                data: { state: state, city: city },
                success: function(streets) {
                    streetInstance.addOption({value:"", text:"Select Street"});
                    $.each(streets, function(index, street) {
                        streetInstance.addOption({value: street.value, text: street.name});
                    });
                    streetInstance.refreshOptions(false);
                    if(selectedStreet) {
                        streetInstance.setValue(selectedStreet);
                    }
                },
                error: function(err) {
                    console.log('Error fetching streets:', err);
                }
            });
        }

        function loadPostcodes(state, city, street) {
            var postcodeInstance = $('#postcodeDropdown')[0].selectize;
            postcodeInstance.clearOptions();
            $.ajax({
                url: '/user/postcodes',
                method: 'GET',
                data: { state: state, city: city, street: street },
                success: function(postcodes) {
                    postcodeInstance.addOption({value:"", text:"Select Postcode"});
                    $.each(postcodes, function(index, postcode) {
                        postcodeInstance.addOption({value: postcode.value, text: postcode.name});
                    });
                    postcodeInstance.refreshOptions(false);
                    if(selectedPostcode) {
                        postcodeInstance.setValue(selectedPostcode);
                    }
                },
                error: function(err) {
                    console.log('Error fetching postcodes:', err);
                }
            });
        }

        // Populate the nationality dropdown via AJAX
        $.ajax({
            url: '/user/countries',
            method: 'GET',
            success: function(countries) {
                var nationalityInstance = $('#nationalityDropdown')[0].selectize;
                nationalityInstance.clearOptions();
                nationalityInstance.addOption({value:"", text:"Please select"});
                $.each(countries, function(index, country) {
                    nationalityInstance.addOption({value: country.alpha_2_code, text: country.en_short_name});
                });
                nationalityInstance.refreshOptions(false);
            },
            error: function(err) {
                console.log('Error fetching countries:', err);
            }
        });

        // Populate the state dropdown via AJAX
        $.ajax({
            url: '/user/states',
            method: 'GET',
            success: function(states) {
                var stateInstance = $('#stateDropdown')[0].selectize;
                stateInstance.clearOptions();
                stateInstance.addOption({value:"", text:"Select State"});
                $.each(states, function(index, state) {
                    stateInstance.addOption({value: state.value, text: state.name});
                });
                stateInstance.refreshOptions(false);
                if(selectedState) {
                    stateInstance.setValue(selectedState);
                }
            },
            error: function(err) {
                console.log('Error fetching states:', err);
            }
        });

        // Attach onChange event to state selectize to load cities
        var stateSelectize = $('#stateDropdown')[0].selectize;
        stateSelectize.on('change', function(value) {
            console.log("State changed: " + value);
            if(value) {
                loadCities(value);
            }
        });

        // Attach onChange event to city selectize to load streets
        var citySelectize = $('#cityDropdown')[0].selectize;
        citySelectize.on('change', function(value) {
            console.log("City changed: " + value);
            var stateVal = $('#stateDropdown')[0].selectize.getValue();
            if(stateVal && value) {
                loadStreets(stateVal, value);
            }
        });

        // Attach onChange event to street selectize to load postcodes
        var streetSelectize = $('#streetDropdown')[0].selectize;
        streetSelectize.on('change', function(value) {
            console.log("Street changed: " + value);
            var stateVal = $('#stateDropdown')[0].selectize.getValue();
            var cityVal = $('#cityDropdown')[0].selectize.getValue();
            if(stateVal && cityVal && value) {
                loadPostcodes(stateVal, cityVal, value);
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
                                <label for="company_name" class="form-label">{!! __('Company Name') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <input type="text" class="form-control mb-0 @error('company_name') is-invalid @enderror" id="" name="company_name" placeholder="Company Name" value="{!! old('company_name') !!}" required>
                                @error('company_name')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="company_registration_number" class="form-label">{!! __('Company Registration Number') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <input type="text" class="form-control mb-0 @error('company_registration_number') is-invalid @enderror" id="" name="company_registration_number" placeholder="Company Registration Number" value="{!! old('company_registration_number') !!}" required>
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
                                <label for="tax_id" class="form-label">{!! __('Tax ID') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <input type="text" class="form-control mb-0 @error('tax_id') is-invalid @enderror" id="" name="tax_id" placeholder="Tax ID" value="{!! old('tax_id') !!}">
                                @error('tax_id')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="business_license_document" class="form-label">{!! __('Business License') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <input type="file" class="form-control mb-0 @error('business_license_document') is-invalid @enderror" id="" name="business_license_document" placeholder="Business License" value="{!! old('business_license_document') !!}" required>
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
                                <label for="contact_person_name" class="form-label">{!! __('Contact Person Name') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <input type="text" class="form-control mb-0 @error('contact_person_name') is-invalid @enderror" id="" name="contact_person_name" placeholder="Contact Person Name" value="{!! old('contact_person_name') !!}" required>
                                @error('contact_person_name')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-box">
                                <label for="business_address" class="form-label">{!! __('Business Address') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <input type="text" class="form-control mb-0 @error('business_address') is-invalid @enderror" id="" name="business_address" placeholder="Business Address" value="{!! old('business_address') !!}" required>
                                @error('business_address')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-box">
                                <label class="form-label">{!! __('State') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <select name="state" id="stateDropdown" class="@error('state') is-invalid @enderror" required>
                                    <option value="">{!! __('Please select') !!}</option>
                                </select>
                                @error('state')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="city" class="form-label">{!! __('City') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <select name="city" id="cityDropdown" class="@error('city') is-invalid @enderror" required>
                                    <option value="">{!! __('Please select') !!}</option>
                                </select>
                                @error('city')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="street_address" class="form-label">{!! __('Street') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <select name="street_address" id="streetDropdown" class="@error('street_address') is-invalid @enderror" required>
                                    <option value="">{!! __('Please select') !!}</option>
                                </select>
                                @error('street_address')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="postcode" class="form-label">{!! __('Postcode') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <select name="postcode" id="postcodeDropdown" class="@error('postcode') is-invalid @enderror" required>
                                    <option value="">{!! __('Please select') !!}</option>
                                </select>
                                @error('postcode')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="bank_name_account" class="form-label">{!! __('Bank Name Account') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <input type="text" class="form-control mb-0 @error('bank_name_account') is-invalid @enderror" id="" name="bank_name_account" placeholder="Bank Name Account" value="{!! old('bank_name_account') !!}" required>
                                @error('bank_account_details')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="bank_account_details" class="form-label">{!! __('Bank Account Details') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <input type="text" class="form-control mb-0 @error('bank_account_details') is-invalid @enderror" id="" name="bank_account_details" placeholder="Bank Account Details" value="{!! old('bank_account_details') !!}" required>
                                @error('bank_account_details')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-box">
                                <label for="product_categories" class="form-label">{!! __('Product Categories') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <select name="product_categories" id="productCategories" class="@error('product_categories') is-invalid @enderror" required>
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
                                <label for="email" class="form-label">{!! __('Email') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <input type="email" class="form-control mb-0 @error('email') is-invalid @enderror" id="" name="email" placeholder="Email" value="{!! old('email') !!}" required>
                                @error('email')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="phone" class="form-label">{!! __('Phone') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <input type="text" class="form-control mb-0 @error('phone') is-invalid @enderror" id="" name="phone" placeholder="Phone" value="{!! old('phone') !!}" required>
                                @error('phone')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="password" class="form-label">{!! __('Password') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <input type="password" class="form-control mb-0 @error('password') is-invalid @enderror" id="" name="password" placeholder="Enter your password" value="{!! old('password') !!}" required>
                                @error('password')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="password_confirmation" class="form-label">{!! __('Confirmation Password') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <input type="password" class="form-control mb-0 @error('password_confirmation') is-invalid @enderror" id="" name="password_confirmation" placeholder="Re-enter your password" value="{!! old('password_confirmation') !!}" required>
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
