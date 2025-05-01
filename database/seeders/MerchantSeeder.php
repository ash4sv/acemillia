<?php

namespace Database\Seeders;

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
        Schema::enableForeignKeyConstraints();

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
                'menu_setup_id'               => 2,
                'status_submission'           => 'approved',
                'email_verified_at'            => now(),
                'remember_token'              => Str::random(10),
            ]
        ];

        foreach ($merchants as $merchant) {
            $registerName = ucfirst($merchant['name']);
            $char = $registerName[0] ?? '';

            $createdMerchant = Merchant::create(
                array_merge($merchant, [
                    'name' => $registerName,
                    'icon_avatar' => $char,
                ])
            );
            $createdMerchant->assignRole('merchant');
        }
    }
}
