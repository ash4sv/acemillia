<?php

namespace App\Services\CourierServices;

use App\Models\Admin\Service\ShippingProvider;
use App\Contracts\ShippingRateProviderInterface;
use App\Services\CourierServices\EasyParcelRateProvider;

class RateCheckingService
{
    public function getProviderInstance(string $providerName): ?ShippingRateProviderInterface
    {
        return match (strtolower($providerName)) {
            'easyparcel'     => new EasyParcelRateProvider(),
            // 'myparcelasia' => new MyParcelAsiaRateProvider(),
            default          => null,
        };
    }

    public function fetchAndStoreRates(ShippingProvider $provider): array
    {
        $handler = $this->getProviderInstance($provider->name);

        if (!$handler) {
            throw new \Exception("No handler implemented for: {$provider->name}");
        }

        return $handler->fetchRates($provider);
    }
}
