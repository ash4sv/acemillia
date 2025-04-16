<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected array $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs = [
            ['label' => 'Home', 'url' => route('web.index')],
        ];
    }
}
