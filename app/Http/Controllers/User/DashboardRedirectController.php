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
            case 'notifications':
                return app()->call('App\Http\Controllers\User\DashboardUserController@notifications');
            case 'my-order':
                return app()->call('App\Http\Controllers\User\DashboardUserController@myOrders');
            case 'saved-address':
                return app()->call('App\Http\Controllers\User\AddressUserController@index');
            default:
                return app()->call('App\Http\Controllers\User\DashboardUserController@index');
        }
    }
}
