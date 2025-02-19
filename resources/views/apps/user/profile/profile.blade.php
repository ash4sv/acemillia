<form class="theme-form" action="{{ route('profile.update') }}" method="POST">
    @csrf
    <div class="form-box mb-3">
        <label for="" class="form-label">Full Name</label>
        <input type="text" name="name" id="" class="form-control" value="{{ old('name', $authUser->name ?? '') }}">
    </div>
    <div class="form-box mb-3">
        <label for="" class="form-label">Email</label>
        <input type="email" name="email" id="" class="form-control" value="{{ old('name', $authUser->email ?? '') }}" readonly>
    </div>
    <div class="form-box mb-3">
        <label for="" class="form-label">Phone Number</label>
        <input type="text" name="phone" id="" class="form-control" value="{{ old('name', $authUser->phone ?? '') }}">
    </div>
    <button type="submit" class="btn btn-solid w-auto">Submit</button>
</form>
