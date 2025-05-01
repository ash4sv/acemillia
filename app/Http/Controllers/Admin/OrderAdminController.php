<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\OrderAdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class OrderAdminController extends Controller
{
    protected string $view = 'apps.admin.order.';
    protected string $title = 'Order';

    /**
     * Display a listing of the resource.
     */
    public function index(OrderAdminDataTable $dataTable)
    {
        $title = 'Delete Post!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return $dataTable->render( $this->view . 'index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->view . 'form', [
            'order' => null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->updateOrCreateOrder($request);
        Alert::success('Successfully Create!', $this->title . 'slider has been created!');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view($this->view . 'show', [
            'order' => $this->findOrFailOrder($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view($this->view . 'form', [
            'order' => $this->findOrFailOrder($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->updateOrCreateOrder($request, $id);
        Alert::success('Successfully Update!', $this->title . 'slider has been updated!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = $this->findOrFailOrder($id);
        $order->delete();
        Alert::success('Successfully Deleted!', $this->title . 'slider has been deleted!');
        return back();
    }

    /**
     * Fetch Order by ID or fail.
     */
    private function findOrFailOrder(string $id): Order
    {
        return Order::findOrFail($id);
    }

    /**
     * Save or update a CarouselSlider.
     */
    private function updateOrCreateOrder(Request $request, string $id = null): Order
    {
        DB::beginTransaction();
        try {
            $order = null;

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
