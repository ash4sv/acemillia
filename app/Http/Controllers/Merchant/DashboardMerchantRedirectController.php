<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DashboardMerchantRedirectController extends Controller
{
    public function index(Request $request)
    {
        $section = $request->query('section');

        switch ($section) {
            case 'news-feed':
                return app()->call('App\Http\Controllers\Merchant\NewsFeedMerchantController@index');
            case 'products':
                return app()->call('App\Http\Controllers\Merchant\ProductMerchantController@index');
            case 'product-create':
                return app()->call('App\Http\Controllers\Merchant\ProductMerchantController@create');
            case 'orders':
                return app()->call('App\Http\Controllers\Merchant\DashboardMerchantController@orders');
            case 'order-show':
                return app()->call('App\Http\Controllers\Merchant\DashboardMerchantController@orderShow');
            case 'profile':
                return app()->call('App\Http\Controllers\Merchant\DashboardMerchantController@profile');
            case 'profile-edit':
                return app()->call('App\Http\Controllers\Merchant\DashboardMerchantController@profileEdit');
            case 'password-edit':
                return app()->call('App\Http\Controllers\Merchant\DashboardMerchantController@passwordEdit');
            case 'address-edit':
                return app()->call('App\Http\Controllers\Merchant\DashboardMerchantController@addressEdit');
            case 'settings':
                return app()->call('App\Http\Controllers\Merchant\DashboardMerchantController@settings');
            case 'wallet':
                return app()->call('App\Http\Controllers\Merchant\WalletWithdrawRequestMerchantController@index');
            default:
                return app()->call('App\Http\Controllers\Merchant\DashboardMerchantController@index');
        }
    }
}
