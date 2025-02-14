<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardUserController extends Controller
{
    public function index()
    {
        $authUser = auth()->user();
        return response()->view('apps.user.dashboard.index', [
            'authUser' => $authUser
        ]);
    }
}
