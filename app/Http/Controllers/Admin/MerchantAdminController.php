<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\MerchantAdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class MerchantAdminController extends Controller
{
    protected string $view = 'apps.admin.registered-user.merchants.';

    /**
     * Display a listing of the resource.
     */
    public function index(MerchantAdminDataTable $dataTable)
    {
        return $dataTable->render($this->view . 'index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view($this->view . 'form', [

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Alert::success('Successfully Create!', 'Merchant has been created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $merchant = Merchant::with(['address', 'menuSetup'])->findOrFail($id);
        return response()->view($this->view . 'show', [
            'merchant' => $merchant,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->view($this->view . 'form', [
            'merchant' => $this->findOrFailMerchant($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->updateOrCreateMerchant($request, $id);
        Alert::success('Successfully Update!', 'Merchant has been updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $merchant = $this->findOrFailMerchant($id);
        $merchant->delete();
        Alert::success('Successfully Deleted!', 'Merchant has been deleted!');
        return redirect()->back();
    }

    /**
     * Fetch Merchant by ID or fail.
     */
    private function findOrFailMerchant(string $id): Merchant
    {
        return Merchant::findOrFail($id);
    }

    /**
     * Save or update a Merchant.
     */
    private function updateOrCreateMerchant(Request $request, string $id = null): Merchant
    {
        DB::beginTransaction();
        try {
            $data = $request->only([
                'submission'
            ]);

            $merchant = Merchant::updateOrCreate(
                ['id' => $id],
                array_merge($data, [
                    'status_submission' => $data['submission'],
                ])
            );

            DB::commit();
            return $merchant;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
