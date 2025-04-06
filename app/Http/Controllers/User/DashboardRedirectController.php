<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardRedirectController extends Controller
{
    public function index(Request $request)
    {
        $section = $request->query('section');

        switch ($section) {
            case 'news-feed':
                return app()->call('App\Http\Controllers\User\NewsFeedUserController@index');
            case 'notifications':
                return app()->call('App\Http\Controllers\User\DashboardUserController@notifications');
            case 'my-order':
                return app()->call('App\Http\Controllers\User\DashboardUserController@myOrders');
            case 'my-order-show':
                return app()->call('App\Http\Controllers\User\DashboardUserController@myOrderShow');
            case 'saved-address':
                return app()->call('App\Http\Controllers\User\AddressUserController@index');
            default:
                return app()->call('App\Http\Controllers\User\DashboardUserController@index');
        }
    }
}
