<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ImageUploader;
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

    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => 'Login'],
        ]);

        if (auth()->guard('web')->check()) {
            return redirect()->route('dashboard');
        }
        return response()->view($this->view . 'login', [
            'breadcrumbs' => $breadcrumbs
        ]);
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
        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => 'Register'],
        ]);

        $genders = [
            ['name' => 'male'],
            ['name' => 'female'],
        ];

        $countries = public_path('assets/data/countries.json');

        if (auth()->guard('web')->check()) {
            return redirect()->route('dashboard');
        }
        return response()->view($this->view . 'register', [
            'genders' => $genders,
            'countries' => $countries,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function registerAuth(Request $request)
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'gender'                => 'required|string|max:10',
            'date_of_birth'         => 'required|date',
            'nationality'           => 'required|string|max:255',
            'identification_number'  => 'required|string|max:255',
            'upload_documents'      => 'required|file|mimes:pdf,jpg,jpeg,png',
            'address'               => 'required|string|max:255',
            'state'                 => 'required|string|max:255',
            'city'                  => 'required|string|max:255',
            'street_address'        => 'required|string|max:255',
            'postcode'              => 'required|string|max:20',
            'email'                 => 'required|string|email|max:255|unique:users',
            'phone_number'          => 'required|string|max:20',
            'password'              => 'required|string|min:8|confirmed',
            // 'cf-turnstile-response' => ['required', Rule::turnstile()],
        ]);

        $documentFilePath = $request->file('upload_documents')
            ? ImageUploader::uploadSingleImage($request->file('upload_documents'), 'assets/upload/', $data['name'] . '_document')
            : (null);

        $registerName = $data['name'];
        $char = $registerName[0] ?? '';

        $user = User::create([
            'name'                 => $registerName,
            'gender'               => $data['gender'],
            'phone'                => $data['phone_number'],
            'date_of_birth'        => $data['date_of_birth'],
            'nationality'          => $data['nationality'],
            'identification_number' => $data['identification_number'],
            'upload_documents'     => $documentFilePath,
            'email'                => $data['email'],
            'password'             => Hash::make($data['password']),
            'email_verified_at'     => null,
            'remember_token'       => Str::random(10),
            'icon_avatar'          => $char,
            'status_submission'    => 'pending'
        ]);

        $user->addressBooks()->create([
            'recipient_name' => $data['name'],
            'title'          => 'Default Address',
            'phone'          => $data['phone_number'],
            'address'        => $data['address'],
            'country'        => 'MY',
            'state'          => $data['state'],
            'city'           => $data['city'],
            'street_address' => $data['street_address'],
            'postcode'       => $data['postcode'],
        ]);

        $user->assignRole('user');

        $user->sendUserEmailVerificationNotification();
        Auth::guard('web')->login($user);
        Alert::success('User registration successful!', 'Please check your email to verify your account.');
        return redirect()->route('verification.notice');
    }

    public function forgetPassword()
    {
        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => 'Forgot password'],
        ]);

        if (auth()->guard('web')->check()) {
            return redirect()->route('dashboard');
        }
        return response()->view($this->view . 'password-request', [
            'breadcrumbs' => $breadcrumbs
        ]);
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
        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => 'Reset Password'],
        ]);

        if (auth()->guard('web')->check()) {
            return redirect()->route('dashboard');
        }
        return response()->view($this->view . 'reset-password', [
            'request' => $request,
            'breadcrumbs' => $breadcrumbs
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
