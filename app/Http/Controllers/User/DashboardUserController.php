<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardUserController extends Controller
{
    protected $authUser;

    public function __construct()
    {
        $this->authUser = auth()->guard('web')->user();
    }

    public function index(Request $request)
    {
        return response()->view('apps.user.dashboard.index', [
            'authUser' => $this->authUser
        ]);
    }

    public function notifications(Request $request)
    {
        return response()->view('apps.user.notifications.index', [
            'authUser' => $this->authUser
        ]);
    }

    public function myOrders(Request $request)
    {
        return response()->view('apps.user.my-orders.index', [
            'authUser' => $this->authUser
        ]);
    }
}
