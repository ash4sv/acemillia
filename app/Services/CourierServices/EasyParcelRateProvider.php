<?php

namespace App\Services\CourierServices;

use App\Contracts\ShippingRateProviderInterface;
use App\Models\Admin\Service\Courier;
use App\Models\Admin\Service\ShippingProvider;
use Illuminate\Support\Facades\Http;

class EasyParcelRateProvider implements ShippingRateProviderInterface
{

    public function fetchRates(ShippingProvider $provider): array
    {
        $baseUrl = env('APP_ENV') === 'production' ? rtrim($provider->live_url, '/') : rtrim($provider->demo_url, '/');
        $url = $baseUrl . '?&ac=MPRateCheckingBulk';

        $postData = [
            'authentication' => $provider->api_secret,
            'api' => $provider->api_key,
            'bulk' => [[
                'pick_code' => '10050',
                'pick_state' => 'png',
                'pick_country' => 'MY',
                'send_code' => '11950',
                'send_state' => 'png',
                'send_country' => 'MY',
                'weight' => 1.0,
                'width' => 10,
                'length' => 10,
                'height' => 10,
                'date_coll' => date('Y-m-d'),
            ]],
        ];

        $response = Http::timeout(60)->asForm()->post($url, $postData);
        $data = $response->json();

        if (!$response->ok()) {
            throw new \Exception("Failed to fetch rates from {$provider->name}");
        }

        $courierIds = [];

        if ($data['api_status'] === 'Success' && isset($data['result'][0]['rates'])) {
            foreach ($data['result'][0]['rates'] as $rate) {
                $courier = Courier::updateOrCreate(
                    [
                        'shipping_provider_id' => $provider->id,
                        'service_code' => $rate['service_id'],
                    ],
                    [
                        'image' => $rate['courier_logo'],
                        'name' => $rate['courier_name'],
                        'service_name' => $rate['service_name'],
                        'delivery_time' => $rate['delivery'],
                        'rate' => $rate['price'],
                        'status' => 'active',
                    ]
                );
                $courierIds[] = $courier->id;
            }
        }

        return $courierIds;
    }
}
