<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('merchants')->truncate();
        Schema::enableForeignKeyConstraints();

        $users = [
            [
                'name'              => 'Muhamad Ashraf Test Account',
                'email'             => 'cuzpcdev@gmail.com',
                'password'          => Hash::make('password'),
                'email_verified_at'  => now(),
                'remember_token'    => Str::random(10),
                'status_submission' => 'approved',
            ]
        ];

        foreach ($users as $user) {
            $registerName = ucfirst($user['name']);
            $char = $registerName[0] ?? '';

            $createdUser = User::create([
                'name'              => $registerName,
                'email'             => $user['email'],
                'password'          => $user['password'],
                'email_verified_at'  => $user['email_verified_at'],
                'remember_token'    => $user['remember_token'],
                'icon_avatar'       => $char,
                'status_submission' => $user['status_submission'],
            ]);
            $createdUser->assignRole('user');
        }
    }
}
