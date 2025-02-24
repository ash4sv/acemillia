<form class="theme-form" action="{!! route('user.password.update') !!}" method="POST">
    @csrf
    <div class="form-box mb-3">
        <label for="current_password" class="form-label">Current Password</label>
        <input type="password" name="current_password" id="current_password" class="form-control">
    </div>
    <div class="form-box mb-3">
        <label for="password" class="form-label">New Password</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>
    <div class="form-box mb-3">
        <label for="password_confirmation" class="form-label">New Password Confirmation</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
    </div>
    <button type="submit" class="btn btn-solid w-auto">Submit</button>
</form>
