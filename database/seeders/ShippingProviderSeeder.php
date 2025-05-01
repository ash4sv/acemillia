<?php

namespace Database\Seeders;

use App\Models\Admin\Service\ShippingProvider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ShippingProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        ShippingProvider::truncate();
        Schema::enableForeignKeyConstraints();

        $shippingProviders = [
            [
                'name'       => 'EasyParcel Malaysia Marketplaces',
                'api_key'    => 'EP-SjDFzW57y',
                'api_secret' => 'bxfUbSExnA',
                'demo_url'   => 'https://demo.connect.easyparcel.my/',
                'live_url'   => 'https://connect.easyparcel.my/',
                'status'     => 'active',
            ],
            [
                'name'       => 'MyParcel Asia',
                'api_key'    => '',
                'api_secret' => '',
                'demo_url'   => '',
                'live_url'   => '',
                'status'     => 'active',
            ],
        ];

        foreach ($shippingProviders as $shippingProvider) {
            ShippingProvider::create($shippingProvider);
        }
    }
}
