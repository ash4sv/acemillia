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
                                <label for="name" class="form-label">{!! __('Full Name') !!}</label>
                                <input type="text" class="form-control mb-0 @error('name') is-invalid @enderror" id="" name="name" placeholder="Full Name" value="{!! old('name') !!}">
                                @error('name')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="gender" class="form-label">{!! __('Gender') !!}</label>
                                <select
                                    {!! old('gender') !!}
                                    name="gender" id="" class="form-select @error('gender') is-invalid @enderror">
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
                                <label for="email" class="form-label">{!! __('Date of Birth') !!}</label>
                                <input type="text" class="form-control mb-0 @error('date_of_birth') is-invalid @enderror" id="" name="date_of_birth" placeholder="Date of Birth" value="{!! old('date_of_birth') !!}">
                                @error('date_of_birth')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="nationality" class="form-label">{!! __('Nationality') !!}</label>
                                <select
                                    {!! old('nationality') !!}
                                    name="nationality" id="nationalityDropdown" class="form-select @error('nationality') is-invalid @enderror">
                                    <option value="">Please select</option>
                                </select>
                                @error('nationality')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="identification_number" class="form-label">{!! __('Identification Number') !!}</label>
                                <input type="text" class="form-control mb-0 @error('identification_number') is-invalid @enderror" id="" name="identification_number" placeholder="Identification Number" value="{!! old('identification_number') !!}">
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
                                <label for="upload_documents" class="form-label">{!! __('Upload Documents') !!}</label>
                                <input type="file" class="form-control mb-0 @error('upload_documents') is-invalid @enderror" id="" name="upload_documents" placeholder="Upload Documents" value="{!! old('upload_documents') !!}">
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
                                <label for="address" class="form-label">{!! __('Address') !!}</label>
                                <input type="text" name="address" id="" class="form-control mb-0 @error('address') is-invalid @enderror" value="{!! old('address') !!}">
                                @error('address')
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
                                <label for="email" class="form-label">{!! __('Email') !!}</label>
                                <input type="email" class="form-control mb-0 @error('email') is-invalid @enderror" id="" name="email" placeholder="Email" value="{!! old('email') !!}">
                                @error('email')
                                <div class="invalid-feedback">{!! $message !!}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="phone_number" class="form-label">{!! __('Phone Number') !!}</label>
                                <input type="text" class="form-control mb-0 @error('phone_number') is-invalid @enderror" id="" name="phone_number" placeholder="Phone Number" value="{!! old('phone_number') !!}">
                                @error('phone_number')
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
