<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('adminrole', function () {
            return Auth::guard('admin')->check() && Auth::guard('admin')->user()->hasAnyRole(['system', 'admin']);
        });

        Blade::if('merchantrole', function () {
            return Auth::guard('merchant')->check() && Auth::guard('merchant')->user()->hasRole('merchant');
        });

        Blade::if('userrole', function () {
            return Auth::guard('web')->check() && Auth::guard('web')->user()->hasRole('user');
        });

        Blade::if('logoutAllowed', function ($roles) {
            $isAdmin    = Auth::guard('admin')->check() && Auth::guard('admin')->user()->hasAnyRole($roles);
            $isMerchant = Auth::guard('merchant')->check() && Auth::guard('merchant')->user()->hasAnyRole($roles);
            $isUser     = Auth::guard('web')->check() && Auth::guard('web')->user()->hasAnyRole($roles);
            return $isAdmin || $isMerchant || $isUser;
        });

        Blade::if('customCan', function ($permission) {
            $hasPermission = false;
            if (Auth::guard('admin')->check()) {
                $hasPermission = Auth::guard('admin')->user()->can($permission);
            } elseif (Auth::guard('merchant')->check()) {
                $hasPermission = Auth::guard('merchant')->user()->can($permission);
            } elseif (Auth::guard('web')->check()) {
                $hasPermission = Auth::guard('web')->user()->can($permission);
            }
            return $hasPermission;
        });

        //
        // URL::forceScheme('https');
    }
}
