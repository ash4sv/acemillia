<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use App\Models\Order\SubOrder;
use App\Services\LocationService;
use App\Traits\GeneratesPdfs;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ShipmentGeneralAdminController extends Controller
{
    use GeneratesPdfs;

    public function generatePo(Request $request)
    {
        $data = $request->validate([
            'merchant'  => 'required|exists:merchants,id',
            'order'     => 'required|exists:orders,id',
            'sub_order' => 'required|exists:sub_orders,id',
        ]);

        $subOrder = SubOrder::with([
            'order.shippingAddress',
            'merchant',
            'items.product'
        ])->findOrFail($data['sub_order']);

        if ($subOrder->po_number) {
            $poNumber = $subOrder->po_number;
        } else {
            $poNumber = 'PO-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4));
            $subOrder->po_number = $poNumber;
        }
        $relativePath = $this->generatePurchaseOrderPdf($subOrder);
        $subOrder->purchase_order = $relativePath;
        $subOrder->save();

        return response()->json([
            'success'   => true,
            'po_number' => $poNumber,
            'pdf_url'   => asset($relativePath),
        ]);
    }

    public function generateReceipt(Request $request)
    {
        $data = $request->validate([
            'order' => 'required|exists:orders,id',
        ]);

        $order = Order::with([
            'shippingAddress',
            'billingAddress',
            'subOrders.items.product'
        ])->findOrFail($data['order']);

        $relative = $this->generateReceiptPdf($order);

        return response()->json([
            'success'  => true,
            'pdf_url'  => asset($relative),
            'filename' => $relative,
        ]);
    }
}
