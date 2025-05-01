<form class="theme-form" action="{{ route('user.profile.update') }}" method="POST">
    @csrf
    <div class="form-box mb-3">
        <label for="" class="form-label">Full Name</label>
        <input type="text" name="name" id="" class="form-control" value="{{ old('name', $authUser->name ?? '') }}">
    </div>
    <div class="form-box mb-3">
        <label for="" class="form-label">Gender</label>
        <select
            {!! old('gender') !!}
            name="gender" id="gender" class="@error('gender') is-invalid @enderror" required>
            <option value="">Please select</option>
            @foreach($genders as $key => $gender)
                <option value="{!! $gender['name'] !!}">{!! ucfirst($gender['name']) !!}</option>
            @endforeach
        </select>
    </div>
    <div class="form-box mb-3">
        <label for="" class="form-label">Date of Birth</label>
        <input type="text" class="form-control mb-0 @error('date_of_birth') is-invalid @enderror jqueryuidate" id="" name="date_of_birth" placeholder="Date of Birth" value="{!! old('date_of_birth', $authUser->date_of_birth ?? '') !!}">
    </div>
    <div class="form-box mb-3">
        <label for="" class="form-label">Nationality</label>
        <select
            {!! old('nationality') !!}
            name="nationality" id="nationalityDropdown" class="@error('nationality') is-invalid @enderror" required>
            <option value="">Please select</option>
        </select>
    </div>
    <div class="form-box mb-3">
        <label for="identification_number" class="form-label">Identification Number</label>
        <input type="text" name="identification_number" id="identification_number" class="form-control" value="{{ old('', $authUser->identification_number ?? '') }}">
    </div>
    <div class="form-box mb-3">
        <label for="" class="form-label">Upload Documents</label>
        <input type="file" name="" id="" class="form-control">
    </div>
    <div class="form-box mb-3">
        <label for="" class="form-label">Email</label>
        <input type="email" name="email" id="" class="form-control" value="{{ old('email', $authUser->email ?? '') }}" readonly>
    </div>
    <div class="form-box mb-3">
        <label for="" class="form-label">Phone Number</label>
        <input type="text" name="phone" id="" class="form-control" value="{{ old('phone', $authUser->phone ?? '') }}">
    </div>
    <button type="submit" class="btn btn-solid w-auto">Submit</button>
</form>
