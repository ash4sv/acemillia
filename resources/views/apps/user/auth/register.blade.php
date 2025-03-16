@extends('apps.layouts.shop')

@section('description', '')
@section('keywords', '')
@section('author', '')
@section('title', 'Create account')

@push('style')

@endpush

@push('script')
<script>
    $(document).ready(function(){
        const cacheDuration = 3600000; // 1 hour in milliseconds

        // --- Utility functions for caching AJAX responses ---
        function isCacheValid(key) {
            let cache = localStorage.getItem(key);
            if (cache) {
                let parsed = JSON.parse(cache);
                return (new Date().getTime() - parsed.timestamp) < cacheDuration;
            }
            return false;
        }

        function getCache(key) {
            if (isCacheValid(key)) {
                return JSON.parse(localStorage.getItem(key)).data;
            }
            return null;
        }

        function setCache(key, data) {
            localStorage.setItem(key, JSON.stringify({
                timestamp: new Date().getTime(),
                data: data
            }));
        }

        // --- Utility functions for caching form data ---
        const formCacheKey = 'create_account_form_data';

        function saveFormData() {
            // Gather values from text inputs, selects, and textareas (skip file inputs)
            let formData = {
                name: $('input[name="name"]').val(),
                gender: $('#gender').val(),
                date_of_birth: $('input[name="date_of_birth"]').val(),
                nationality: $('#nationalityDropdown').val(),
                identification_number: $('input[name="identification_number"]').val(),
                address: $('input[name="address"]').val(),
                state: $('#stateDropdown').val(),
                city: $('#cityDropdown').val(),
                street_address: $('#streetDropdown').val(),
                postcode: $('#postcodeDropdown').val(),
                email: $('input[name="email"]').val(),
                phone_number: $('input[name="phone_number"]').val(),
                // Exclude password fields if you prefer not to store them
            };
            localStorage.setItem(formCacheKey, JSON.stringify({
                timestamp: new Date().getTime(),
                data: formData
            }));
        }

        function restoreFormData() {
            let saved = localStorage.getItem(formCacheKey);
            if (saved) {
                let parsed = JSON.parse(saved);
                // If cached data is not expired
                if (new Date().getTime() - parsed.timestamp < cacheDuration) {
                    let data = parsed.data;
                    $('input[name="name"]').val(data.name);
                    $('#gender')[0].selectize.setValue(data.gender);
                    $('input[name="date_of_birth"]').val(data.date_of_birth);
                    $('#nationalityDropdown')[0].selectize.setValue(data.nationality);
                    $('input[name="identification_number"]').val(data.identification_number);
                    $('input[name="address"]').val(data.address);
                    $('#stateDropdown')[0].selectize.setValue(data.state);
                    $('#cityDropdown')[0].selectize.setValue(data.city);
                    $('#streetDropdown')[0].selectize.setValue(data.street_address);
                    $('#postcodeDropdown')[0].selectize.setValue(data.postcode);
                    $('input[name="email"]').val(data.email);
                    $('input[name="phone_number"]').val(data.phone_number);
                } else {
                    localStorage.removeItem(formCacheKey);
                }
            }
        }

        // Clear form cache on form submission
        $('form').on('submit', function(){
            localStorage.removeItem(formCacheKey);
        });

        // Save form data on any change (excluding file inputs)
        $('input:not([type="file"]), select, textarea').on('change keyup', saveFormData);

        // Initialize jQuery UI DatePicker
        $(".jqueryuidate").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: '1900:' + new Date().getFullYear(),
            maxDate: 0,
            monthNames: [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ]
        });

        // Pre-initialize static selectize elements.
        // (These calls convert the <select> into selectize instances)
        $('#gender, #nationalityDropdown, #stateDropdown, #cityDropdown, #streetDropdown, #postcodeDropdown').selectize({
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
                        <a href="{!! url('/') !!}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">{!! strtoupper(__('Create account')) !!}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!--section start-->
    <section class="login-page section-b-space">
        <div class="container">
            <h3>create account</h3>
            <div class="theme-card">
                <form class="theme-form" action="{{ route('auth.register') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="name" class="form-label">{!! __('Full Name') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <input type="text" class="form-control mb-0 @error('name') is-invalid @enderror" id="" name="name" placeholder="Full Name" value="{!! old('name') !!}" required>
                                @error('name')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="gender" class="form-label">{!! __('Gender') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <select
                                    {!! old('gender') !!}
                                    name="gender" id="gender" class="@error('gender') is-invalid @enderror" required>
                                    <option value="">Please select</option>
                                    @foreach($genders as $key => $gender)
                                    <option value="{!! $gender['name'] !!}">{!! ucfirst($gender['name']) !!}</option>
                                    @endforeach
                                </select>
                                @error('gender')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="email" class="form-label">{!! __('Date of Birth') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <input type="text" class="form-control mb-0 @error('date_of_birth') is-invalid @enderror jqueryuidate" id="" name="date_of_birth" placeholder="Date of Birth" value="{!! old('date_of_birth') !!}" required>
                                @error('date_of_birth')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="nationality" class="form-label">{!! __('Nationality') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <select
                                    {!! old('nationality') !!}
                                    name="nationality" id="nationalityDropdown" class="@error('nationality') is-invalid @enderror" required>
                                    <option value="">Please select</option>
                                </select>
                                @error('nationality')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="identification_number" class="form-label">{!! __('Identification Number') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <input type="text" class="form-control mb-0 @error('identification_number') is-invalid @enderror" id="" name="identification_number" placeholder="Identification Number" value="{!! old('identification_number') !!}" required>
                                <div class="form-text pt-1 text-secondary">
                                    {!! __('(Identification Card / Passport / Driving License)') !!}
                                </div>
                                @error('identification_number')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="upload_documents" class="form-label">{!! __('Upload Documents') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <input type="file" class="form-control mb-0 @error('upload_documents') is-invalid @enderror" id="" name="upload_documents" placeholder="Upload Documents" value="{!! old('upload_documents') !!}" required>
                                <div class="form-text pt-1 text-secondary">
                                    {!! __('(Identification Card / Passport / Driving License for verification). File support pdf, jpg, jpeg, and png') !!}
                                </div>
                                @error('upload_documents')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-box">
                                <label for="address" class="form-label">{!! __('Address') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <input type="text" name="address" id="" class="form-control mb-0 @error('address') is-invalid @enderror" placeholder="Address" value="{!! old('address') !!}" required>
                                @error('address')
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
                                <label for="email" class="form-label">{!! __('Email') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <input type="email" class="form-control mb-0 @error('email') is-invalid @enderror" id="" name="email" placeholder="Email" value="{!! old('email') !!}" required>
                                @error('email')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="phone_number" class="form-label">{!! __('Phone Number') !!} <span class="text-danger">{!! __('*') !!}</span></label>
                                <input type="text" class="form-control mb-0 @error('phone_number') is-invalid @enderror" id="" name="phone_number" placeholder="Phone Number" value="{!! old('phone_number') !!}" required>
                                @error('phone_number')
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
