<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function dashboard()
    {
        return view('apps.admin.dashboard.index');
    }
}
