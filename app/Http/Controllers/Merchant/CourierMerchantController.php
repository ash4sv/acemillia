<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Admin\Service\Courier;
use App\Models\Admin\Service\ShippingProvider;
use App\Models\Order\SubOrder;
use App\Services\CourierServices\RateCheckingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourierMerchantController extends Controller
{
    public function fetchFromProvider(Request $request, RateCheckingService $rateCheckingService)
    {
        $request->validate([
            'pick_code'    => 'required',
            'pick_state'   => 'required',
            'pick_country' => 'required',
            'send_code'    => 'required',
            'send_state'   => 'required',
            'send_country' => 'required',
            'weight'       => 'required|numeric',
            'width'        => 'nullable|numeric',
            'length'       => 'nullable|numeric',
            'height'       => 'nullable|numeric',
        ]);

        $params = $request->only([
            'pick_code', 'pick_state', 'pick_country',
            'send_code', 'send_state', 'send_country',
            'weight', 'width', 'length', 'height',
        ]);

        $providers = ShippingProvider::active()->get();
        $courierIds = [];

        foreach ($providers as $provider) {
            try {
                $courierIds = array_merge(
                    $courierIds,
                    $rateCheckingService->fetchAndStoreRates($provider, $params)
                );
            } catch (\Throwable $e) {
                report($e);
                return response()->json([
                    'success' => false,
                    'error' => "Failed to fetch from provider: {$provider->name}",
                ], 500);
            }
        }

        $couriers = Courier::whereIn('id', $courierIds)
            ->active()
            ->get()
            ->sortBy('rate')
            ->values()
            ->map(function ($courier) {
                return [
                    'id' => $courier->id,
                    'name' => $courier->name,
                    'image' => asset($courier->image ?? 'images/default-courier.png'),
                    'service_name' => $courier->service_name,
                    'delivery_time' => $courier->delivery_time,
                    'rate' => number_format($courier->rate, 2),
                ];
            });

        return response()->json([
            'success' => true,
            'total' => $couriers->count(),
            'couriers' => $couriers,
        ]);
    }


    public function submitOrder(Request $request, RateCheckingService $rateService)
    {
        $request->validate([
            'courier_id'   => 'required|exists:couriers,id',
            'weight'       => 'required|numeric',
            'width'        => 'nullable|numeric',
            'length'       => 'nullable|numeric',
            'height'       => 'nullable|numeric',
            'content'      => 'required|string|max:35',
            'value'        => 'required|numeric',
            'collect_date' => 'required|date',
            'sub_order_id' => 'required|exists:sub_orders,id',
        ]);

        $courier = Courier::find($request->courier_id);
        $provider = $courier->shippingProvider;

        $subOrder = SubOrder::with('order.shippingAddress')->findOrFail($request->sub_order_id);
        $shipping = $subOrder->order->shippingAddress;

        $payload = $request->all();

        $payload['send_name']    = $shipping->recipient_name ?? $subOrder->order?->user?->name;
        $payload['send_contact'] = $shipping->phone;
        $payload['send_addr1']   = $shipping->address;
        $payload['send_city']    = $shipping->city;
        $payload['send_state']   = $shipping->state;
        $payload['send_code']    = $shipping->postcode;
        $payload['send_country'] = $shipping->country;
        $payload['send_email']   = $subOrder->order?->user?->email;

        try {
            $result = $rateService->submitEasyParcelOrder($provider, $courier, $payload);
            $balance = $rateService->checkEasyParcelCredit($provider);

            if ($balance) {
                $paymentResult = $rateService->payEasyParcelOrder($provider, [$result['order_number']]);

                $shipment = $subOrder->order->shipment()->create([
                    'courier_id'      => $courier->id,
                    'tracking_number' => null,
                    'awb_url'         => null,
                    'pickup_date'     => null,
                    'delivery_date'   => null,
                    'shipment_status' => 'pending',
                ]);

                if ($shipment) {
                    foreach($subOrder->items as $item) {
                        $shipment->shipmentItems()->create([
                            'order_item_id' => $item->id,
                            'quantity'      => $item->quantity,
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'data' => $result,
                'payment_result' => $paymentResult,
            ]);
        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'success' => false,
                'error' => 'Failed to submit order.',
            ]);
        }
    }
}
