<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthMerchantController extends Controller
{
    protected string $view  = 'apps.merchant.auth.';
    protected string $route = 'merchant.';

    public function redirect()
    {
        return response()->view($this->view . 'index');
    }

    public function login()
    {

    }

    public function loginAuth()
    {

    }

    public function register()
    {

    }

    public function registerAuth()
    {

    }

    public function forgetPassword()
    {

    }

    public function forgetPasswordAuth()
    {

    }

    public function resetPassword()
    {

    }

    public function resetPasswordAuth()
    {

    }

    public function destroy()
    {

    }
}
