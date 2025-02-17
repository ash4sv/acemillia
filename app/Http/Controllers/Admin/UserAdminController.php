<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UserAdminDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    protected string $view = 'apps.admin.registered-user.customers.';

    /**
     * Display a listing of the resource.
     */
    public function index(UserAdminDataTable $dataTable)
    {
        $title = 'Delete Category!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return $dataTable->render($this->view . 'index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
