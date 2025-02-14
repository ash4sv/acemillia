<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class CustomEnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $guard = 'web'): Response
    {
        $user = auth()->guard($guard)->user();

        // Determine the redirect route based on the guard
        $redirectToRoute = match ($guard) {
            'admin' => 'admin.verification.notice',
            'merchant' => 'merchant.verification.notice',
            default => 'verification.notice',
        };

        // Check if the user is not verified
        if (!$user || ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail())) {
            return $request->expectsJson()
                ? abort(403, 'Your email address is not verified.')
                : Redirect::route($redirectToRoute);
        }

        return $next($request);
    }
}
