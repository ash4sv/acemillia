<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\CourierAdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin\Service\Courier;
use App\Models\Admin\Service\ShippingProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class CourierAdminController extends Controller
{
    protected string $view = 'apps.admin.shipping-service.courier.';
    protected string $title = 'Couriers';

    public function __construct()
    {
        parent::__construct();
        $this->shippingProviders = ShippingProvider::active()->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(CourierAdminDataTable $dataTable)
    {
        /*$easyParcel = ShippingProvider::active()->where('name', 'EasyParcel Malaysia Marketplaces')->first();

        $baseUrl = env('APP_ENV') === 'production' ? rtrim($easyParcel->live_url, '/') : rtrim($easyParcel->demo_url, '/');
        $url = $baseUrl . '?&ac=MPRateCheckingBulk'; */

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
            'courier' => null,
            'shippingProviders' => $this->shippingProviders,
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
            'courier' => $this->findOrFailCourier($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view($this->view . 'form', [
            'courier' => $this->findOrFailCourier($id),
            'shippingProviders' => $this->shippingProviders,
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
        $courier = $this->findOrFailCourier($id);
        $courier->delete();
        Alert::success('Successfully Deleted!', $this->title . ' has been deleted!');
        return back();
    }

    /**
     * Fetch Courier by ID or fail.
     */
    private function findOrFailCourier(string $id): Courier
    {
        return Courier::findOrFail($id);
    }

    /**
     * Save or update a Shipping Provider.
     */
    private function updateOrCreateShippingProvider(Request $request, string $id = null): Courier
    {
        DB::beginTransaction();
        try {
            $data = $request->only([
                'name',
                'service_code',
                'service_name',
                'delivery_time',
                'rate',
            ]);

            $data['shipping_provider_id'] = $request->input('shipping_provider');
            $data['status'] = $request->input('publish');

            $courier = Courier::updateOrCreate(
                ['id' => $id],
                $data
            );

            DB::commit();
            return $courier;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
