<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // If the user is approved and tries to access the pending approval page (e.g. the verification notice route),
        // redirect them to the dashboard with a success message.
        if ($user && $user->status_submission === 'approved' && $request->routeIs('under.review')) {
            Alert::success('Your account is approved!', 'Your account is now active and you can make purchases.');
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
