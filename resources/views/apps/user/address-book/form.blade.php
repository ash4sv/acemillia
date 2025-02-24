@php
    $route = 'user.saved-address.';
@endphp

<div class="theme-modal-2">
    <form action="{{ isset($addressBook) ? route( $route . 'update', $addressBook->id) : route( $route . 'store') }}" enctype="multipart/form-data" class="mb-0 form" method="POST">
        @csrf
        @if(isset($addressBook))
            @method('PUT')
        @endif

        <div class="row g-sm-4 g-2">
            <div class="col-12">
                <div class="form-box">
                    <label for="title" class="form-label">{!! __('Title') !!}</label>
                    <input type="text" class="form-control" name="title" placeholder="Enter Title" value="{!! old('title', $addressBook->title ?? '') !!}">
                </div>
            </div>
            <div class="col-12">
                <div class="form-box">
                    <label for="recipient_name" class="form-label">{!! __('Recipient Name') !!}</label>
                    <input type="text" class="form-control" name="recipient_name" placeholder="Enter Recipient Name" value="{!! old('title', $addressBook->recipient_name ?? '') !!}">
                </div>
            </div>
            <div class="col-12">
                <div class="form-box">
                    <label for="number" class="form-label">{!! __('Phone Number') !!}</label>
                    <input type="number" class="form-control" name="phone" placeholder="Enter Your Phone Number" value="{!! old('phone', $addressBook->phone ?? '') !!}">
                </div>
            </div>
            <div class="col-12">
                <div class="form-box">
                    <label for="address" class="form-label">{!! __('Address') !!}</label>
                    <input type="text" class="form-control" name="address" placeholder="Enter Address" value="{!! old('address', $addressBook->address ?? '') !!}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-box">
                    <label class="form-label">{!! __('Country') !!}</label>
                    <select name="country" class="form-select" readonly="">
                        <option value="MY">Malaysia</option>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-box">
                    <label class="form-label">{!! __('State') !!}</label>
                    <select name="state" id="stateDropdown" class="form-select"></select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-box">
                    <label for="city" class="form-label">{!! __('City') !!}</label>
                    <select name="city" id="cityDropdown" class="form-select"></select>
                </div>
            </div>
            <div class="col-12">
                <div class="form-box">
                    <label for="street_address" class="form-label">{!! __('Street') !!}</label>
                    <select name="street_address" id="streetDropdown" class="form-select"></select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-box">
                    <label for="postcode" class="form-label">{!! __('Postcode') !!}</label>
                    <select name="postcode" id="postcodeDropdown" class="form-select"></select>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-solid w-auto">{{ isset($addressBook) ? 'Update' : 'Create' }} {!! __('Address') !!}</button>
            </div>
        </div>

    </form>
</div>

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
