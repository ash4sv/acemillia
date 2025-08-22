<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Schema::disableForeignKeyConstraints();
        Admin::truncate();
        Schema::enableForeignKeyConstraints();

        $admins = [
            [
                'name'             => 'SYSTEM',
                'email'            => 'sys@ardianexus.com',
                'email_verified_at' => now(),
                'password'         => Hash::make('asdfgh12'),
            ],
            [
                'name'             => 'ADMIN',
                'email'            => 'admin@ardianexus.com',
                'email_verified_at' => now(),
                'password'         => Hash::make('asdfgh12'),
            ],
            [
                'name'             => 'ADMIN',
                'email'            => 'admin@acemillia.com',
                'email_verified_at' => now(),
                'password'         => Hash::make('gRrDLZZxHB6h)+'),
            ],
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }

        $sysAdmin = Admin::where('email', 'sys@ardianexus.com')->first();
        $sysAdmin->assignRole('system');

        $adminAdmin = Admin::where('email', 'admin@ardianexus.com')->first();
        $adminAdmin->assignRole('admin');

        $adminAdmin = Admin::where('email', 'admin@acemillia.com')->first();
        $adminAdmin->assignRole('admin');

    }
}
