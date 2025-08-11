<div class="card shadow-none border-1 border-solid">
    <x-show-header
        title="Customer Details"
        :editRoute="route('admin.registered-user.users.edit', $user->id)"
        :indexRoute="route('admin.registered-user.users.index')"
    />
    <div class="card-body">
        <div class="mb-3">
            <label for="name" class="form-label">{!! __('Full Name') !!}</label>
            <input type="text" name="name" class="form-control" disabled value="{!! old('', $user->name ?? '') !!}">
        </div>

        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="email" class="form-label">{!! __('Email') !!}</label>
                    <input type="text" name="email" class="form-control" disabled value="{!! old('', $user->email ?? '') !!}">
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="phone" class="form-label">{!! __('Phone') !!}</label>
                    <input type="text" name="phone" class="form-control" disabled value="{!! old('', $user->phone ?? '') !!}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="date_of_birth" class="form-label">{!! __('Date of Birth') !!}</label>
                    <input type="text" name="date_of_birth" class="form-control" disabled value="{!! old('', $user->date_of_birth ?? '') !!}">
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="gender" class="form-label">{!! __('Gender') !!}</label>
                    <input type="text" name="gender" class="form-control" disabled value="{!! old('', ucfirst($user->gender) ?? '') !!}">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="nationality" class="form-label">{!! __('Nationality') !!}</label>
            <input type="text" name="nationality" class="form-control" disabled value="{!! old('', $user->nationality ?? '') !!}" data-nationality="{!! $user->nationality ?? '' !!}">
        </div>
        <div class="mb-3">
            <label for="identification_number" class="form-label">{!! __('Identification Number') !!}</label>
            <input type="text" name="identification_number" class="form-control" disabled value="{!! old('', $user->identification_number ?? '') !!}">
        </div>
        <div class="mb-3">
            <label for="upload_documents" class="form-label">{!! __('Documents') !!}</label>
            <div class="input-group">
                <input type="text" name="upload_documents" class="form-control" disabled value="{!! old('', $user->upload_documents ?? '') !!}">
                <a href="{!! asset($user->upload_documents) !!}" class="btn btn-outline-secondary" target="_blank">View Document</a>
            </div>
        </div>

        @if($user->addressBooks && $user->addressBooks->isNotEmpty())
            @foreach($user->addressBooks as $address)
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">{!! __('Address') !!}</label>
                            <input type="text" class="form-control" disabled value="{!! $address->address !!}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">{!! __('State') !!}</label>
                            <input type="text" class="form-control" disabled value="{!! $address->state !!}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">{!! __('City') !!}</label>
                            <input type="text" class="form-control" disabled value="{!! $address->city !!}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">{!! __('Street') !!}</label>
                            <input type="text" class="form-control" disabled value="{!! $address->street_address !!}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">{!! __('Postcode') !!}</label>
                            <input type="text" class="form-control" disabled value="{!! $address->postcode !!}">
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<script>
    $(document).ready(function(){
        var $nationalityInput = $('input[name="nationality"]');
        var nationalityCode = $nationalityInput.data('nationality');

        if(nationalityCode) {
            $.ajax({
                url: '/user/countries',
                method: 'GET',
                success: function(countries) {
                    var matchedCountry = countries.find(function(country) {
                        return country.alpha_2_code === nationalityCode;
                    });
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
