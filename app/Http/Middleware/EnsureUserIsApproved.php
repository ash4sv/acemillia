<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // If the user is logged in but not approved and trying to access purchase-related routes,
        // redirect them to the profile edit page with a warning.
        if ($user && $user->status_submission === 'pending') {
            Alert::warning('Your account is under review!', 'Purchase features are not available until approved.');

            if ($user->hasRole('merchant')) {
                return redirect()->route('merchant.under.review');
            } elseif ($user->hasRole('user')) {
                return redirect()->route('under.review');
            }
            // Fallback in case no matching role is found.
            return redirect()->route('under.review');
        }

        return $next($request);
    }
}
