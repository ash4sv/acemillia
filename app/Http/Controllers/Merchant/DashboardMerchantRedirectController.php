<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardMerchantRedirectController extends Controller
{
    public function index(Request $request)
    {
        $section = $request->query('section');

        switch ($section) {
            case 'products':
                return app()->call('App\Http\Controllers\Merchant\DashboardMerchantController@products');
            case 'product-create':
                return app()->call('App\Http\Controllers\Merchant\DashboardMerchantController@productCreate');
            case 'orders':
                return app()->call('App\Http\Controllers\Merchant\DashboardMerchantController@orders');
            case 'profile':
                return app()->call('App\Http\Controllers\Merchant\DashboardMerchantController@profile');
            case 'profile-edit':
                return app()->call('App\Http\Controllers\Merchant\DashboardMerchantController@profileEdit');
            case 'password-edit':
                return app()->call('App\Http\Controllers\Merchant\DashboardMerchantController@passwordEdit');
            case 'settings':
                return app()->call('App\Http\Controllers\Merchant\DashboardMerchantController@settings');
            default:
                return app()->call('App\Http\Controllers\Merchant\DashboardMerchantController@index');
        }
    }
}
