<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use RealRashid\SweetAlert\Facades\Alert;

class AuthMerchantVerifyController extends Controller
{
    private function redirectPath()
    {
        return '/merchant/dashboard';
    }

    public function notice(Request $request)
    {
        $user = $request->user();

        if ($user && $user->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        $email = auth()->guard('merchant')->user()->email ?? '';
        return view('apps.merchant.auth.verify-email', ['email' => $email]);
    }

    public function verify(EmailVerificationRequest $request)
    {
        if (!$request->user()) {
            throw new AuthorizationException;
        }

        if ($request->route('id') != $request->user()->getKey()) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        Alert::success('Email successfully verified!', 'You are logged in');
        return redirect($this->redirectPath())->with('verified', true);
    }

    public function resend(Request $request)
    {
        if (!$request->user()) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        $request->user()->sendMerchantEmailVerificationNotification();

        Alert::success('Successfully sent!', 'A fresh verification link has been sent to your email address.');
        return back()->with('resent', true);
    }

    public function underReview()
    {
        return view('apps.merchant.auth.under-review');
    }
}
