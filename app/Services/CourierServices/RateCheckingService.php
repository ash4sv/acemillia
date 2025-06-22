<?php

namespace App\Services\CourierServices;

use App\Models\Admin\Service\ShippingProvider;
use App\Contracts\ShippingRateProviderInterface;
use App\Services\CourierServices\EasyParcelRateProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RateCheckingService
{
    public function getProviderInstance(string $providerName): ?ShippingRateProviderInterface
    {
        return match ($providerName) {
            'EasyParcel Malaysia Marketplaces' => new EasyParcelRateProvider(),
            // 'myparcelasia' => new MyParcelAsiaRateProvider(),
            default          => null,
        };
    }

    public function fetchAndStoreRates(ShippingProvider $provider, array $params): array
    {
        $handler = $this->getProviderInstance($provider->name);

        if (!$handler) {
            throw new \Exception("No handler implemented for: {$provider->name}");
        }

        return $handler->fetchRates($provider, $params);
    }

    public function submitEasyParcelOrder($provider, $courier, $payload): array
    {
        $handler = $this->getProviderInstance($provider->name);

        if (!$handler) {
            throw new \Exception("No handler implemented for: {$provider->name}");
        }

        return $handler->submitOrder($provider, $courier, $payload);
    }

    public function payEasyParcelOrder(ShippingProvider $provider, array $orderNumber): array
    {
        $handler = $this->getProviderInstance($provider->name);

        if (!$handler) {
            throw new \Exception("No handler implemented for: {$provider->name}");
        }

        return $handler->payOrder($provider, $orderNumber);
    }

    public function checkEasyParcelCredit(ShippingProvider $provider): array
    {
        $handler = $this->getProviderInstance($provider->name);

        if (!$handler) {
            throw new \Exception("No handler for: {$provider->name}");
        }

        return $handler->checkCreditBalance($provider);
    }
}
