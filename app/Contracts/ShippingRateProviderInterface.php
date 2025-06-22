<?php

namespace App\Contracts;

use App\Models\Admin\Service\Courier;
use App\Models\Admin\Service\ShippingProvider;

interface ShippingRateProviderInterface
{
    public function fetchRates(ShippingProvider $provider, array $params): array;

    public function submitOrder(ShippingProvider $provider, Courier $courier, array $payload): array;

    public function payOrder(ShippingProvider $provider, array $orderNumbers): array;

    public function checkCreditBalance(ShippingProvider $provider): array;
}
