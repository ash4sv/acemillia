<?php

namespace App\Support;

class LogOut
{
    public static function LogOut()
    {
        return [
            [
                'role'          => ['system', 'admin'],
                'dropdown-item' => [
                    'formUrl' => route('admin.auth.destroy'),
                    'formId'  => 'admin-logout-form',
                ],
                'dropdown-index' => [
                    'formUrl' => route('merchant.auth.destroy'),
                    'formId'  => 'merchant-logout-form',
                ],
            ],

            [
                'role'          => ['merchant'],
                'dropdown-item' => [
                    'formUrl' => route('merchant.auth.destroy'),
                    'formId'  => 'merchant-logout-form',
                ],
                'dropdown-index' => [
                    'url' => route('merchant.dashboard'),
                ],
            ],

            [
                'role'          => ['user'],
                'dropdown-item' => [
                    'formUrl' => route('auth.destroy'),
                    'formId'  => 'user-logout-form',
                ],
                'dropdown-index' => [
                    'url' => route('dashboard'),
                ],
            ],
        ];
    }
}
