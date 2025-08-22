@php
    $route = 'admin.registered-user.users.';
@endphp

<form id="modal-form" action="{{ isset($user) ? route( $route . 'update', $user->id) : route( $route . 'store') }}" enctype="multipart/form-data" class="mb-0" method="POST">
    @csrf
    @if(isset($user))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="name" class="form-label">{!! __('Full Name') !!}</label>
        <input type="text" name="name" id="" class="form-control" disabled value="{!! old('', $user ->name ?? '') !!}">
    </div>

    <div class="row">
        <div class="col-6">
            <div class="mb-3">
                <label for="email" class="form-label">{!! __('Email') !!}</label>
                <input type="text" name="email" id="" class="form-control" disabled value="{!! old('', $user->email ?? '') !!}">
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label for="phone" class="form-label">{!! __('Phone') !!}</label>
                <input type="text" name="phone" id="" class="form-control" disabled value="{!! old('', $user->phone ?? '') !!}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="mb-3">
                <label for="date_of_birth" class="form-label">{!! __('Date of Birth') !!}</label>
                <input type="text" name="date_of_birth" id="" class="form-control" disabled value="{!! old('', $user->date_of_birth ?? '') !!}">
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label for="gender" class="form-label">{!! __('Gender') !!}</label>
                <input type="text" name="gender" id="" class="form-control" disabled value="{!! old('', ucfirst($user ->gender) ?? '') !!}">
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="nationality" class="form-label">{!! __('Nationality') !!}</label>
        <input type="text" name="nationality" id="" class="form-control" disabled value="{!! old('', $user->nationality ?? '') !!}" data-nationality="{!! $user->nationality ?? '' !!}">
    </div>
    <div class="mb-3">
        <label for="identification_number" class="form-label">{!! __('Identification Number') !!}</label>
        <input type="text" name="identification_number" id="" class="form-control" disabled value="{!! old('', $user->identification_number ?? '') !!}">
    </div>
    <div class="mb-3">
        <label for="upload_documents" class="form-label">{!! __('Documents') !!}</label>
        <div class="input-group">
            <input type="text" name="upload_documents" id="" class="form-control" disabled value="{!! old('', $user->upload_documents ?? '') !!}">
            <a href="{!! asset($user->upload_documents) !!}" class="btn btn-outline-secondary" target="_blank">View Document</a>
        </div>
    </div>
    @if($user->addressBooks && $user->addressBooks->isNotEmpty())
        @foreach($user->addressBooks as $address)
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="" class="form-label">{!! __('Address') !!}</label>
                        <input type="text" name="" id="" disabled class="form-control" value="{!! $address->address !!}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="" class="form-label">{!! __('State') !!}</label>
                        <input type="text" name="" id="" disabled class="form-control" value="{!! $address->state !!}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="" class="form-label">{!! __('City') !!}</label>
                        <input type="text" name="" id="" disabled class="form-control" value="{!! $address->city !!}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="" class="form-label">{!! __('Street') !!}</label>
                        <input type="text" name="" id="" disabled class="form-control" value="{!! $address->street_address !!}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="" class="form-label">{!! __('Postcode') !!}</label>
                        <input type="text" name="" id="" disabled class="form-control" value="{!! $address->postcode !!}">
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <div class="mb-3">
        {!! \App\Services\Publish::submissionBtn($user->status_submission ?? 'Pending') !!}
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        <small class="form-text text-muted">Leave blank to keep existing password.</small>
    </div>

    <div class="mb-0">
        <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update' : 'Create' }} User</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
    </div>
</form>

<script>
    $(document).ready(function(){
        // Select the input field that holds the nationality code in its data attribute
        var $nationalityInput = $('input[name="nationality"]');
        var nationalityCode = $nationalityInput.data('nationality'); // e.g., "AF"

        if(nationalityCode) {
            // Fetch the list of countries
            $.ajax({
                url: '/user/countries',
                method: 'GET',
                success: function(countries) {
                    // Find the country object matching the nationality code (using alpha_2_code)
                    var matchedCountry = countries.find(function(country) {
                        return country.alpha_2_code === nationalityCode;
                    });
                    // If a match is found, update the input's value with the country's en_short_name
                    if(matchedCountry) {
                        $nationalityInput.val(matchedCountry.en_short_name);
                    }
                },
                error: function(err) {
                    console.log('Error fetching countries:', err);
                }
            });
        }
    });
</script>
