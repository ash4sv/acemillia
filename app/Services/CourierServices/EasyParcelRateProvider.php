<?php

namespace App\Services\CourierServices;

use App\Contracts\ShippingRateProviderInterface;
use App\Models\Admin\Service\Courier;
use App\Models\Admin\Service\ShippingProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EasyParcelRateProvider implements ShippingRateProviderInterface
{

    public function fetchRates(ShippingProvider $provider, array $params): array
    {
        $baseUrl = env('APP_ENV') === 'production' ? rtrim($provider->live_url, '/') : rtrim($provider->demo_url, '/');
        $url = $baseUrl . '?&ac=MPRateCheckingBulk';

        $postData = [
            'authentication' => $provider->api_secret,
            'api' => $provider->api_key,
            'bulk' => [[
                'pick_code'    => $params['pick_code'],
                'pick_state'   => strtolower($params['pick_state']),
                'pick_country' => $params['pick_country'],
                'send_code'    => $params['send_code'],
                'send_state'   => strtolower($params['send_state']),
                'send_country' => $params['send_country'],
                'weight'       => $params['weight'],
                'width'        => $params['width'],
                'length'       => $params['length'],
                'height'       => $params['height'],
                'date_coll'    => date('Y-m-d'),
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
                        'merchant_id' => auth()->guard('merchant')->id(),
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

    public function submitOrder(ShippingProvider $provider, Courier $courier, array $payload): array
    {
        $baseUrl = app()->environment('production') ? rtrim($provider->live_url, '/') : rtrim($provider->demo_url, '/');
        $url = $baseUrl . '?&ac=MPSubmitOrderBulk';

        $pickContact = preg_replace('/[^0-9]/', '', $payload['pick_contact'] ?? '60123456789');
        $sendContact = preg_replace('/[^0-9]/', '', $payload['send_contact'] ?? '60123456789');

        $postData = [
            'authentication' => $provider->api_secret,
            'api' => $provider->api_key,
            'bulk' => [[
                'weight'       => $payload['weight'],
                'width'        => $payload['width'],
                'length'       => $payload['length'],
                'height'       => $payload['height'],
                'content'      => $payload['content'],
                'value'        => $payload['value'],
                'service_id'   => $courier->service_code,
                'pick_point'   => '',
                'pick_name'    => $payload['pick_name'],
                'pick_contact' => $pickContact,
                'pick_addr1'   => $payload['pick_addr1'],
                'pick_city'    => $payload['pick_city'],
                'pick_state'   => strtolower($payload['pick_state']),
                'pick_code'    => $payload['pick_code'],
                'pick_country' => $payload['pick_country'],
                'send_name'    => $payload['send_name'] ?? 'Recipient',
                'send_contact' => $sendContact,
                'send_addr1'   => $payload['send_addr1'] ?? 'Default Send Address',
                'send_city'    => $payload['send_city'] ?? 'City',
                'send_state'   => strtolower($payload['send_state'] ?? 'state'),
                'send_code'    => $payload['send_code'] ?? '11950',
                'send_country' => $payload['send_country'] ?? 'MY',
                'collect_date' => $payload['collect_date'],
                'sms'          => false,
                'send_email'   => $payload['send_email'] ?? 'receiver@example.com',
            ]]
        ];

        $response = Http::asForm()->timeout(60)->post($url, $postData);
        $json = $response->json();

        if (!isset($json['result'][0]['order_number'])) {
            throw new \Exception('EasyParcel failed to create order.');
        }

        return $json['result'][0];
    }

    public function payOrder(ShippingProvider $provider, array $orderNumbers): array
    {
        $baseUrl = app()->environment('production') ? rtrim($provider->live_url, '/') : rtrim($provider->demo_url, '/');
        $url = $baseUrl . '?&ac=MPPayOrderBulk';

        $bulk = [];
        foreach ($orderNumbers as $orderNo) {
            $bulk[] = ['order_no' => $orderNo];
        }

        $postData = [
            'authentication' => $provider->api_secret,
            'api' => $provider->api_key,
            'bulk' => $bulk,
        ];

        $response = Http::asForm()->timeout(60)->post($url, $postData);
        $json = $response->json();

        // Log::info(['Pay Order' => $json]);

        if (($json['api_status'] ?? '') !== 'Success') {
            throw new \Exception('Failed to pay EasyParcel order. ' . ($json['error_remark'] ?? ''));
        }

        return $json['result'] ?? [];
    }

    public function checkCreditBalance(ShippingProvider $provider): array
    {
        $baseUrl = app()->environment('production') ? rtrim($provider->live_url, '/') : rtrim($provider->demo_url, '/');
        $url = $baseUrl . '?ac=EPCheckCreditBalance';

        $postData = [
            'authentication' => $provider->api_secret,
            'api' => $provider->api_key,
        ];

        $response = Http::asForm()->timeout(60)->post($url, $postData);
        $json = $response->json();

        // Log::info(['Check Credit Balance' => $json]);

        if (($json['api_status'] ?? '') !== 'Success') {
            throw new \Exception('Failed to check credit balance.');
        }

        return $json;
    }
}
