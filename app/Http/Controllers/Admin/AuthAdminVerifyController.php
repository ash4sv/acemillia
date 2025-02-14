<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AuthAdminVerifyController extends Controller
{
    private function redirectPath()
    {
        // return RouteServiceProvider::EXHIBITOR;
    }

    public function notice(Request $request)
    {
        $user = $request->user();

        if ($user && $user->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        $email = null;
        $email = auth()->guard('admin')->user()->email;
        return view('apps.admin.auth.verify-email', ['email' => $email]);
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

        Alert::success('Thanks for the verification!', 'You may proceed to book your booth');
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

        $request->user()->sendAdminEmailVerificationNotification();

        Alert::success('Successfully sent!', 'Verification link has been sent to your email address');
        return back()->with('resent', true);
    }
}
