<?php

namespace App\Traits;

use App\Models\Order\Order;
use App\Models\Order\SubOrder;
use App\Services\LocationService;
use Barryvdh\DomPDF\Facade\Pdf;

trait GeneratesPdfs
{
    /**
     * Generate & save a receipt PDF for the given Order.
     * Returns the relative path to the saved file.
     */
    public function generateReceiptPdf(Order $order): string
    {
        // 1) Resolve human-readable addresses
        $ship = $order->shippingAddress;
        $bill = $order->billingAddress;

        $shippingAddress = [
            'recipient_name' => $ship->recipient_name,
            'phone'          => $ship->phone,
            'address'        => $ship->address,
            'postcode'       => $ship->postcode,
            'city'           => LocationService::cities((int)$ship->state)
                ->get((int)$ship->city,    '–'),
            'state'          => LocationService::states($ship->country)
                ->get((int)$ship->state,   '–'),
            'country'        => LocationService::countries()
                ->get(strtoupper($ship->country), '–'),
        ];

        $billingAddress = [
            'recipient_name' => $bill->recipient_name,
            'phone'          => $bill->phone,
            'address'        => $bill->address,
            'postcode'       => $bill->postcode,
            'city'           => LocationService::cities((int)$bill->state)
                ->get((int)$bill->city,   '–'),
            'state'          => LocationService::states($bill->country)
                ->get((int)$bill->state,  '–'),
            'country'        => LocationService::countries()
                ->get(strtoupper($bill->country), '–'),
        ];

        // 2) Flatten items & compute totals
        $items    = $order->subOrders->flatMap->items;
        $subtotal = $items->sum(fn($i) => $i->price * $i->quantity);
        $total    = $order->total_amount;

        // 3) Build filename & file paths
        $filename  = 'RECEIPT-' . $order->order_number . '.pdf';
        $publicDir = public_path('assets/upload/pdf/');
        if (! file_exists($publicDir)) {
            mkdir($publicDir, 0755, true);
        }
        $pdfPath  = $publicDir . $filename;
        $relative = 'assets/upload/pdf/' . $filename;

        // 4) Format date
        $date = $order->created_at->format('d-m-Y');

        // 5) Prepare view data
        $pdfData = [
            'order'           => $order,
            'date'            => $date,
            'shippingAddress' => $shippingAddress,
            'billingAddress'  => $billingAddress,
            'items'           => $items,
            'subtotal'        => $subtotal,
            'total'           => $total,
        ];

        // 6) Render & save PDF
        PDF::loadView('apps.user.purchase.purchase-receipt', $pdfData)
            ->setPaper('a4', 'portrait')
            ->save($pdfPath);

        return $relative;
    }

    /**
     * Generate & save a purchase order PDF for the given SubOrder.
     * Returns the relative path to the saved file.
     */
    public function generatePurchaseOrderPdf(SubOrder $subOrder): string
    {
        // 1) Resolve supplier & order shipping address
        $ship = $subOrder->order->shippingAddress;
        $supplier = $subOrder->merchant;

        $shippingAddress = [
            'recipient_name' => $ship->recipient_name,
            'phone'          => $ship->phone,
            'address'        => $ship->address,
            'postcode'       => $ship->postcode,
            'city'           => LocationService::cities((int)$ship->state)
                ->get((int)$ship->city,    '–'),
            'state'          => LocationService::states($ship->country)
                ->get((int)$ship->state,   '–'),
            'country'        => LocationService::countries()
                ->get(strtoupper($ship->country), '–'),
        ];

        $items    = $subOrder->items;
        $subtotal = $items->sum(fn($i) => $i->price * $i->quantity);
        $total    = $subtotal; // adjust if there are fees

        // 2) Filename & file paths
        $poNumber  = $subOrder->po_number;
        $filename  = "$poNumber.pdf";
        $publicDir = public_path('assets/upload/pdf/');
        if (! file_exists($publicDir)) {
            mkdir($publicDir, 0755, true);
        }
        $pdfPath  = $publicDir . $filename;
        $relative = 'assets/upload/pdf/' . $filename;

        // 3) Format date
        $date = now()->format('d-m-Y');

        // 4) Prepare view data
        $pdfData = [
            'subOrder'        => $subOrder,
            'supplier'        => $supplier,
            'shippingAddress' => $shippingAddress,
            'items'           => $items,
            'subtotal'        => $subtotal,
            'total'           => $total,
            'po_number'       => $poNumber,
            'date'            => $date,
        ];

        // 5) Render & save PDF
        PDF::loadView('apps.admin.order.purchase-order', $pdfData)
            ->setPaper([0,0,595.28,841.89], 'portrait')
            ->save($pdfPath);

        return $relative;
    }
}
