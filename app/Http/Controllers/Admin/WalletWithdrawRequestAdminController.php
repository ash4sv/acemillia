<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\WalletWithdrawRequestAdminDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletWithdrawRequestAdminController extends Controller
{
    protected string $view = 'apps.admin.wallet-withdraw-request.';
    protected string $title = 'Wallet Withdraw Request';

    /**
     * Display a listing of the resource.
     */
    public function index(WalletWithdrawRequestAdminDataTable $dataTable)
    {
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
