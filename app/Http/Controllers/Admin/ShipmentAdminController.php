<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ShipmentAdminDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ShipmentAdminController extends Controller
{
    protected string $view = 'apps.admin.shipping-service.shipment.';
    protected string $title = 'Shipments';

    /**
     * Display a listing of the resource.
     */
    public function index(ShipmentAdminDataTable $dataTable)
    {
        $title = 'Delete ' . $this->title . ' !';
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
        Alert::success('Successfully Create!', $this->title . ' has been created!');
        return back();
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
        Alert::success('Successfully Update!', $this->title . ' has been updated!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Alert::success('Successfully Deleted!', $this->title . ' has been deleted!');
        return back();
    }
}
