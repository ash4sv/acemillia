<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CustomEnsureEmailIsVerified;
use App\Http\Middleware\EnsureUserIsApproved;
use App\Http\Middleware\RedirectIfApproved;
use App\Http\Middleware\CustomSessionRedirect;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'purchase/payment-redirect',
            'purchase/payment-webhook',
        ]);
        $middleware->web(append: [
            \RealRashid\SweetAlert\ToSweetAlert::class,
        ]);
        $middleware->alias([
            'apps-verified' => CustomEnsureEmailIsVerified::class,
            'approved'     => EnsureUserIsApproved::class,
            'its_approved' => RedirectIfApproved::class,
            'custom.auth'  => CustomSessionRedirect::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
