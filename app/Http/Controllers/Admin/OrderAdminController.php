<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\OrderAdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin\Service\Courier;
use App\Models\Admin\Service\Shipment;
use Illuminate\Http\Request;
use App\Models\Order\Order;
use App\Models\Order\SubOrder;
use Illuminate\Support\Arr;
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
        $title = 'Delete Order!';
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
        $order = $this->findOrFailOrder($id);
        return view($this->view . 'show', [
            'order' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = $this->findOrFailOrder($id);
        $couriers = Courier::orderBy('name')->get();
        return view($this->view . 'form', [
            'order' => $order,
            'couriers' => $couriers
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
        $order = Order::findOrFail($id);
        $order->load([
            'user',
            'subOrders',
            'subOrders.merchant',
            'subOrders.items',
            'subOrders.items.product',
            'subOrders.items.product.merchant',
            'subOrders.shippingLogs',
            'payment',
            'billingAddress',
            'shippingAddress',
            'shipment',
        ]);
        return $order;
    }

    /**
     * Save or update an Order, its SubOrders and Shipments.
     */
    private function updateOrCreateOrder(Request $request, ?string $id = null): Order
    {
        // 1) Validate all input
        $data = $request->validate($this->rules());

        // 2) Extract only the fields belonging to Order itself
        $orderData = Arr::only($data, ['status']);

        // 3) Wrap in a transaction
        return DB::transaction(function () use ($orderData, $data, $id) {
            // Create or update the Order
            $order = Order::updateOrCreate(
                ['id' => $id],
                $orderData
            );

            // Iterate each submitted SubOrder
            foreach ($data['sub_orders'] as $subId => $subAttrs) {
                // 3a) Upsert the SubOrder
                $sub = SubOrder::updateOrCreate(
                    ['id' => $subId, 'order_id' => $order->id],
                    ['shipping_status' => $subAttrs['shipping_status']]
                );

                // 3b) Upsert the Shipment for this SubOrder
                $shipData = $subAttrs['shipment'] ?? [];
                $shipData['order_id'] = $order->id;
                Shipment::updateOrCreate(
                    ['sub_order_id' => $sub->id],
                    $shipData
                );
            }

            return $order;
        });
    }

    /**
     * Validation rules for creating/updating an Order.
     */
    private function rules(): array
    {
        return [
            'status'                                 => 'required|in:processing,completed,cancelled',
            'sub_orders'                             => 'required|array',
            'sub_orders.*.shipping_status'           => 'required|in:pending,shipped,delivered,cancelled',
            'sub_orders.*.shipment'                  => 'sometimes|array',
            'sub_orders.*.shipment.courier_id'       => 'nullable|exists:couriers,id',
            'sub_orders.*.shipment.tracking_number'  => 'nullable|string|max:191',
            'sub_orders.*.shipment.awb_url'          => 'nullable|url|max:255',
            'sub_orders.*.shipment.pickup_date'      => 'nullable|date',
            'sub_orders.*.shipment.delivery_date'    => 'nullable|date|after_or_equal:sub_orders.*.shipment.pickup_date',
        ];
    }
}
