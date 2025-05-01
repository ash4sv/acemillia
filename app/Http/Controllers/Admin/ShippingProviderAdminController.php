<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ShippingProviderAdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin\Service\ShippingProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ShippingProviderAdminController extends Controller
{
    protected string $view = 'apps.admin.shipping-service.shipping-provider.';
    protected string $title = 'Shipping Provider';

    /**
     * Display a listing of the resource.
     */
    public function index(ShippingProviderAdminDataTable $dataTable)
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
        return view($this->view . 'form', [
            'shippingProvider' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->updateOrCreateShippingProvider($request);
        Alert::success('Successfully Create!', $this->title . ' has been created!');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view($this->view . 'show', [
            'shippingProvider' => $this->findOrFailShippingProvider($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view($this->view . 'form', [
            'shippingProvider' => $this->findOrFailShippingProvider($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->updateOrCreateShippingProvider($request, $id);
        Alert::success('Successfully Update!', $this->title . ' has been updated!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shippingProvider = $this->findOrFailShippingProvider($id);
        $shippingProvider->delete();
        Alert::success('Successfully Deleted!', $this->title . ' has been deleted!');
        return back();
    }

    /**
     * Fetch Shipping Provider by ID or fail.
     */
    private function findOrFailShippingProvider(string $id): ShippingProvider
    {
        return ShippingProvider::findOrFail($id);
    }

    /**
     * Save or update a Shipping Provider.
     */
    private function updateOrCreateShippingProvider(Request $request, string $id = null): ShippingProvider
    {
        DB::beginTransaction();
        try {
            $data = $request->only([
                'name',
                'api_key',
                'api_secret',
                'demo_url',
                'live_url',
            ]);

            $data['status'] = $request->input('publish');

            $shippingProvider = ShippingProvider::updateOrCreate(
                ['id' => $id],
                $data
            );

            DB::commit();
            return $shippingProvider;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
