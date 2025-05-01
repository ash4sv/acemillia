<?php

namespace App\Contracts;

use App\Models\Admin\Service\ShippingProvider;

interface ShippingRateProviderInterface
{
    public function fetchRates(ShippingProvider $provider): array;
}
