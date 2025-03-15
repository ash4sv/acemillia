<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Admin\MenuSetup;
use App\Models\Merchant;
use App\Models\Shop\Category;
use App\Services\ImageUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class AuthMerchantController extends Controller
{
    protected string $view  = 'apps.merchant.auth.';
    protected string $route = 'merchant.';

    public function redirect()
    {
        return response()->view($this->view . 'index');
    }

    public function login()
    {
        if (auth()->guard('merchant')->check()) {
            return redirect()->route('merchant.dashboard');
        }
        return response()->view($this->view . 'login');
    }

    public function loginAuth(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->guard('merchant')->attempt($credentials, $request->remember)) {
            if (auth()->guard('merchant')->user()->email_verified_at == null) {
                auth()->guard('merchant')->user()->sendMerchantEmailVerificationNotification();

                Alert::error('Verify your email', 'You need to verify your email address before accessing the dashboard.');
                return redirect()->route('merchant.verification.notice');
            }
            Alert::success('Successfully logged in!', 'You are now logged in.');
            return redirect()->intended(route('merchant.dashboard'));
        }

        Alert::error('Not valid', 'Login details are not valid.');
        return redirect()->back();
    }

    public function register()
    {
        return response()->view($this->view . 'register', [
            'menus' => MenuSetup::active()->get()
        ]);
    }

    public function registerAuth(Request $request)
    {
        $data = $request->validate([
            'company_name'                => 'required|string|max:255',
            'company_registration_number' => 'required|string|max:255',
            'tax_id'                      => 'required|string|max:25',
            'business_license_document'   => 'required|file|mimes:pdf,jpg,jpeg,png',
            'contact_person_name'         => 'required|string|max:255',
            'business_address'            => 'required|string|max:255',
            'state'                       => 'required|string|max:255',
            'city'                        => 'required|string|max:255',
            'street_address'              => 'required|string|max:255',
            'postcode'                    => 'required|string|max:20',
            'bank_name_account'           => 'required|string|max:255',
            'bank_account_details'        => 'required|string|max:255',
            'product_categories'          => 'required',
            'email'                       => 'required|string|email|max:255|unique:merchants',
            'phone'                       => 'required|string|max:20',
            'password'                    => 'required|string|min:8|confirmed',
        ]);

        $companyNameClear = preg_replace('/\s+/', '-', $data['company_name']);
        $documentFilePath = $request->file('business_license_document')
            ? ImageUploader::uploadSingleImage($request->file('business_license_document'), 'assets/upload/', $companyNameClear . '_license')
            : (null);

        $merchant = Merchant::create(array_merge($data, [
            'name'                      => $data['contact_person_name'],
            'password'                  => Hash::make($data['password']),
            'remember_token'            => Str::random(10),
            'business_license_document' => $documentFilePath,
            'status_submission'         => 'pending'
        ]));

        $merchant->assignRole('merchant');
        $merchant->sendMerchantEmailVerificationNotification();
        auth()->guard('merchant')->login($merchant);
        Alert::success('Merchant registration successful!', 'Please check your email to verify your account.');
        return redirect()->route('merchant.verification.notice');
    }

    public function forgetPassword()
    {
        if (auth()->guard('merchant')->check()) {
            return redirect()->route('merchant.dashboard');
        }
        return response()->view($this->view . 'password-request');
    }

    public function forgetPasswordAuth(Request $request)
    {
        $status = Password::broker('merchants')->sendResetLink(
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
        if (auth()->guard('merchants')->check()) {
            return redirect()->route('merchant.dashboard');
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

        $status = Password::broker('merchants')->reset(
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
            ? redirect()->route('merchant.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function destroy()
    {
        auth()->guard('merchant')->logout();
        Alert::success('Successfully logged out!', 'You are now logged out.');
        return redirect()->route('merchant.login');
    }
}
