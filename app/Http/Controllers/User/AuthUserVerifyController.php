<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AuthUserVerifyController extends Controller
{
    private function redirectPath()
    {
        return '/dashboard';
    }

    public function notice(Request $request)
    {
        $user = $request->user();

        if ($user && $user->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        $email = null;
        $email = auth()->guard('web')->user()->email;
        return view('apps.user.auth.verify-email', ['email' => $email]);
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

        Alert::success('Email successfully verified! You are logged in', 'success');
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

        $request->user()->sendUserEmailVerificationNotification();

        Alert::success('Successfully sent! A fresh verification link has been sent to your email address.', 'success');
        return back()->with('resent', true);
    }

    public function underReview()
    {
        return view('apps.user.auth.under-review');
    }
}
