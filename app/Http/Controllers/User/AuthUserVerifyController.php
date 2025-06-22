<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use RealRashid\SweetAlert\Facades\Alert;

class AuthUserVerifyController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    private function redirectPath()
    {
        return '/dashboard';
    }

    public function notice(Request $request)
    {
        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => 'Verify your email'],
        ]);

        $user = $request->user();

        if ($user && $user->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        $email = null;
        $email = auth()->guard('web')->user()->email;
        return view('apps.user.auth.verify-email', [
            'email' => $email,
            'breadcrumbs' => $breadcrumbs,
        ]);
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

        $request->user()->sendUserEmailVerificationNotification();

        Alert::success('Successfully sent!', 'A fresh verification link has been sent to your email address.');
        return back()->with('resent', true);
    }

    public function underReview()
    {
        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => 'Account is under review'],
        ]);

        return view('apps.user.auth.under-review', [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}
