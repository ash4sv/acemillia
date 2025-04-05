<?php

namespace App\Support;

use Illuminate\Support\Facades\Auth;

class Navbar
{
    public static function getNavUser()
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
        } elseif (Auth::guard('merchant')->check()) {
            $user = Auth::guard('merchant')->user();
        } elseif (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
        } else {
            return [];
        }

        return [
            [
                'name'       => $user->name,
                'rolesNames' => $user->getRoleNames()->first(),
                'image'      => asset('apps/img/avatars/1.png'),
                'role'       => ['user'],
                'url'        => '',
            ],
            [
                'name'       => $user->name,
                'rolesNames' => $user->getRoleNames()->first(),
                'image'      => asset('apps/img/avatars/1.png'),
                'role'       => ['merchant'],
                'url'        => '',
            ],
            [
                'name'       => $user->name,
                'rolesNames' => $user->getRoleNames()->first(),
                'image'      => asset('apps/img/avatars/1.png'),
                'role'       => ['admin'],
                'url'        => '',
            ],
            [
                'name'       => $user->name,
                'rolesNames' => $user->getRoleNames()->first(),
                'image'      => asset('apps/img/avatars/1.png'),
                'role'       => ['system'],
                'url'        => '',
            ],
        ];
    }
}
