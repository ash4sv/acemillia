<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomSessionRedirect
{
    /**
     * Handle an incoming request.
     * Optionally pass a guard parameter (admin, merchant, web).
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        // Bypass for API requests
        if ($request->expectsJson()) {
            return $next($request);
        }

        // Detect guard if not explicitly provided
        $guard = $guard ?: $this->detectGuard($request);

        // Redirect if session is expired or user is not authenticated
        if (!Auth::guard($guard)->check()) {
            return $this->redirectToLogin($guard);
        }

        return $next($request);
    }

    /**
     * Detect guard based on the first URL segment.
     */
    protected function detectGuard(Request $request): string
    {
        $segment = $request->segment(1);
        if ($segment === 'admin') {
            return 'admin';
        }
        if ($segment === 'merchant') {
            return 'merchant';
        }
        return 'web';
    }

    /**
     * Redirect to the appropriate login route.
     */
    protected function redirectToLogin(string $guard)
    {
        return redirect()->route('force-login');
    }
}
