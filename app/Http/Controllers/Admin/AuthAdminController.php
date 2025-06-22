<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AuthAdminController extends Controller
{
    protected string $view  = 'apps.admin.auth.';
    protected string $route = 'admin.';

    public function redirect()
    {
        if (auth()->guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login');
    }

    public function login()
    {
        if (auth()->guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return response()->view($this->view.'login');
    }

    public function loginAuth(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->guard('admin')->attempt($credentials, $request->remember)) {
            if (auth()->guard('admin')->user()->email_verified_at == null) {
                auth()->guard('admin')->logout();
                return redirect()->route('admin.login')->with('error', 'You need to verify your email address.');
            }
            Alert::success('Successfully logged in!', 'You are now logged in.');
            return redirect()->intended(route('admin.dashboard'));
        }
        Alert::error('Not valid', 'Login details are not valid.');
        return redirect()->back();
    }

    public function register()
    {

    }

    public function registerAuth()
    {

    }

    public function forgetPassword()
    {

    }

    public function forgetPasswordAuth()
    {

    }

    public function resetPassword()
    {

    }

    public function resetPasswordAuth()
    {

    }

    public function destroy()
    {
        auth()->guard('admin')->logout();
        Alert::success('Successfully logged out!', 'You are now logged out.');
        return redirect()->route('admin.login');
    }
}
