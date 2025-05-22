<?php

namespace Database\Seeders;

use App\Models\Admin\MenuSetup;
use App\Models\Merchant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('merchants')->truncate();
        DB::table('address_merchants')->truncate();
        Schema::enableForeignKeyConstraints();

        $marketing = MenuSetup::where('name', 'Marketing')->first();

        $merchants = [
            [
                'id'                          => 2,
                'name'                        => 'Miriam Franks',
                'email'                       => 'voza@mailinator.com',
                'password'                    => Hash::make('password'),
                'phone'                       => '+1 (937) 381-6477',
                'company_name'                => 'Ardia Nexus',
                'company_registration_number' => null,
                'tax_id'                      => null,
                'business_license_document'   => null,
                'bank_name_account'           => null,
                'bank_account_details'        => null,
                'menu_setup_id'               => $marketing->id,
                'status_submission'           => 'approved',
                'email_verified_at'            => now(),
                'remember_token'              => Str::random(10),
                'address'                     => [
                    [
                        'country'             => 'MY',
                        'state'               => 'KDH',
                        'city'                => 'Kodiang',
                        'postcode'            => '06100',
                        'street_address'      => 'Kampung Guar Batu Hitam',
                        'business_address'    => 'B-80, Jalan Jakarta Barat',
                    ]
                ],
            ]
        ];


        foreach ($merchants as $data) {
            // 1. Extract & remove the address payload
            $addressData = $data['address'][0] ?? [];
            unset($data['address']);

            // 2. Build the merchant payload
            $data['name']        = ucfirst($data['name']);
            $data['icon_avatar'] = substr($data['name'], 0, 1);

            // 3. Create the merchant (no 'address' key in $data)
            $merchant = Merchant::create($data);

            // 4. Create the related address record
            if ($addressData) {
                $merchant->address()->create($addressData);
            }

            // 5. Assign the 'merchant' role
            $merchant->assignRole('merchant');
        }
    }
}
