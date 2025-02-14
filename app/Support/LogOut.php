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
            ],

            [
                'role'          => ['merchant'],
                'dropdown-item' => [
                    'formUrl' => '#',
                    'formId'  => 'organizer-logout-form',
                ],
            ],

            [
                'role'          => ['user'],
                'dropdown-item' => [
                    'formUrl' => '#',
                    'formId'  => 'user-logout-form',
                ],
            ],
        ];
    }
}
