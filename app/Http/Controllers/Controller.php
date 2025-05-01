<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected array $breadcrumbs, $genders;

    public function __construct()
    {
        $this->breadcrumbs = [
            ['label' => 'Home', 'url' => route('web.index')],
        ];

        $this->genders = [
            ['name' => 'male'],
            ['name' => 'female'],
        ];
    }
}
