<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order\SubOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShipmentGeneralAdminController extends Controller
{
    public function generatePo(Request $request)
    {
        $data = $request->validate([
            'supplier'  => 'required|exists:suppliers,id',
            'order'     => 'required|exists:orders,id',
            'sub_order' => 'required|exists:sub_orders,id',
        ]);

        // Load sub-order with needed relations
        $subOrder = SubOrder::with([
            'order.shippingAddress',
            'supplier',
            'items.product'
        ])->findOrFail($data['sub_order']);

        // 1. Determine or generate PO number
        if ($subOrder->po_number) {
            $poNumber = $subOrder->po_number;
        } else {
            $poNumber = 'PO-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4));
            // persist new PO number
            $subOrder->po_number = $poNumber;
        }

        // 2. Paths
        $filename    = $poNumber . '.pdf';
        $publicDir   = public_path('assets/upload/pdf/');
        if (! file_exists($publicDir)) {
            mkdir($publicDir, 0755, true);
        }
        $pdfPath     = $publicDir . $filename;
        $relativePath= 'assets/upload/pdf/' . $filename;

        // 3. Build PDF data
        $pdfData = [
            'order'     => $subOrder->order,
            'subOrder'  => $subOrder,
            'supplier'  => $subOrder->supplier,
            'items'     => $subOrder->items,
            'po_number' => $poNumber,
            'date'      => now()->format('d-m-Y'),
            'subtotal'  => $subOrder->items->sum(fn($i) => $i->price * $i->quantity),
            'total'     => $subOrder->items->sum(fn($i) => $i->price * $i->quantity),
        ];

        // 4. Render & save PDF (overwriting if needed)
        $customPaper = [0,0,595.28,841.89]; // A4
        PDF::loadView('apps.admin.order.purchase-order', $pdfData)
            ->setPaper($customPaper, 'portrait')
            ->save($pdfPath);

        // 5. Persist purchase_order path (and save po_number if new)
        $subOrder->purchase_order = $relativePath;
        $subOrder->save();

        return response()->json([
            'success'   => true,
            'po_number' => $poNumber,
            'pdf_url'   => asset($relativePath),
        ]);
    }
}
