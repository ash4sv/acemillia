<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class AuthUserController extends Controller
{
    protected string $view  = 'apps.user.auth.';
    protected string $route = '';

    public function login()
    {
        if (auth()->guard('web')->check()) {
            return redirect()->route('dashboard');
        }
        return response()->view($this->view . 'login');
    }

    public function loginAuth(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials, $request->remember)) {
            if (Auth::guard('web')->user()->email_verified_at == null) {
                Auth::guard('web')->user()->sendUserEmailVerificationNotification();

                Alert::error('Verify your email', 'You need to verify your email address before accessing the dashboard.');
                return redirect()->route('verification.notice');
            }
            Alert::success('Successfully logged in!', 'You are now logged in.');
            return redirect()->intended(route('dashboard'));
        }

        Alert::error('Not valid', 'Login details are not valid.');
        return redirect()->back();
    }

    public function register()
    {
        if (auth()->guard('web')->check()) {
            return redirect()->route('dashboard');
        }
        return response()->view($this->view . 'register');
    }

    public function registerAuth(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // 'cf-turnstile-response' => ['required', Rule::turnstile()],
        ]);

        $user = User::create([
            'name' => strtoupper($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => null,
            'remember_token' => Str::random(10),
        ]);

        $user->assignRole('user');

        $user->sendUserEmailVerificationNotification();

        Auth::guard('web')->login($user);

        Alert::success('User registration successful!', 'Please check your email to verify your account.');

        return redirect()->route('verification.notice');
    }

    public function forgetPassword()
    {
        if (auth()->guard('web')->check()) {
            return redirect()->route('dashboard');
        }
        return response()->view($this->view . 'password-request');
    }

    public function forgetPasswordAuth(Request $request)
    {
        $status = Password::broker('users')->sendResetLink(
            $request->only('email'),
            function ($user, $token) {
                $user->sendPasswordResetNotification($token);
            }
        );

        if ($status === Password::RESET_LINK_SENT) {
            Alert::success('Password reset request', 'An email has been successfully sent to the provided email address.');
        }

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword(Request $request)
    {
        if (auth()->guard('web')->check()) {
            return redirect()->route('dashboard');
        }
        return response()->view($this->view . 'reset-password', [
            'request' => $request,
        ]);
    }

    public function resetPasswordAuth(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'token'    => 'required'
        ]);

        $status = Password::broker('users')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            Alert::success('Password successfully reset', 'Please proceed to log in to continue.');
        }

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function destroy()
    {
        auth()->guard('web')->logout();
        Alert::success('Successfully logged out!', 'You are now logged out.');
        return redirect()->route('login');
    }
}
