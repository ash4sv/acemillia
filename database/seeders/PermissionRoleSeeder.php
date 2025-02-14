<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Schema::disableForeignKeyConstraints();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        Permission::truncate();
        Role::truncate();
        Schema::enableForeignKeyConstraints();

        $roles =[
            [
                'name'       => 'system',
                'guard_name' => 'admin',
            ],
            [
                'name'       => 'admin',
                'guard_name' => 'admin',
            ],
            [
                'name'       => 'merchant',
                'guard_name' => 'merchant',
            ],
            [
                'name'       => 'user',
                'guard_name' => 'web',
            ],
            [
                'name'       => 'guest',
                'guard_name' => 'web',
            ],
        ];

        foreach ($roles as $role){
            Role::updateOrCreate([
                'guard_name' => $role['guard_name'],
                'name'       => $role['name'],
            ]);
        }

        $permissions = [
            ['Admin Systems Management', 'admin'],
            ['Admin Authentication User Management', 'admin'],
            ['Admin Access Control Layer', 'admin'],
            ['Admin Admin Management', 'admin'],
            ['Admin Merchant Management', 'admin'],
            ['Admin User Management', 'admin'],
            ['Admin Role Management', 'admin'],
            ['Admin Permission Management', 'admin'],
            ['Admin System Log', 'admin'],

            ['Merchant Systems Management', 'merchant'],

            ['User Systems Management', 'web'],
        ];

        $permissionsData = [];
        foreach ($permissions as $permission) {
            $slug = Str::slug($permission[0]);
            $guardName = $permission[1];

            // Permission actions to append
            $actions = ['access', 'create', 'read', 'update', 'delete'];

            // Collect data for each action
            foreach ($actions as $action) {
                $permissionsData[] = [
                    'name' => $slug . '-' . $action,
                    'guard_name' => $guardName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Save all permissions at once
        Permission::insert($permissionsData);

        $admin = Role::where('name', 'admin')->first();
        $system = Role::where('name', 'system')->first();
        $merchant = Role::where('name', 'merchant')->first();
        $user = Role::where('name', 'user')->first();

        $adminPermissions = [
            'admin-systems-management-access',
            'admin-systems-management-create',
            'admin-systems-management-read',
            'admin-systems-management-update',
            'admin-systems-management-delete',
            'admin-authentication-user-management-access',
            'admin-authentication-user-management-create',
            'admin-authentication-user-management-read',
            'admin-authentication-user-management-update',
            'admin-authentication-user-management-delete',
            'admin-access-control-layer-access',
            'admin-access-control-layer-create',
            'admin-access-control-layer-read',
            'admin-access-control-layer-update',
            'admin-access-control-layer-delete',
            'admin-admin-management-access',
            'admin-admin-management-create',
            'admin-admin-management-read',
            'admin-admin-management-update',
            'admin-admin-management-delete',
            'admin-merchant-management-access',
            'admin-merchant-management-create',
            'admin-merchant-management-read',
            'admin-merchant-management-update',
            'admin-merchant-management-delete',
            'admin-user-management-access',
            'admin-user-management-create',
            'admin-user-management-read',
            'admin-user-management-update',
            'admin-user-management-delete',
            'admin-role-management-access',
            'admin-role-management-create',
            'admin-role-management-read',
            'admin-role-management-update',
            'admin-role-management-delete',
            'admin-permission-management-access',
            'admin-permission-management-create',
            'admin-permission-management-read',
            'admin-permission-management-update',
            'admin-permission-management-delete',
            'admin-system-log-access',
            'admin-system-log-create',
            'admin-system-log-read',
            'admin-system-log-update',
            'admin-system-log-delete',
        ];

        $adminPermissionsGet = Permission::whereIn('name', $adminPermissions)->get();

        foreach ($adminPermissionsGet as $adminPermission) {
            $admin->givePermissionTo($adminPermission);
            $system->givePermissionTo($adminPermission);
        }

        $merchantPermissions = [
            'merchant-systems-management-access',
            'merchant-systems-management-create',
            'merchant-systems-management-read',
            'merchant-systems-management-update',
            'merchant-systems-management-delete',
        ];

        $merchantPermissionsGet = Permission::whereIn('name', $merchantPermissions)->get();

        foreach ($merchantPermissionsGet as $merchantPermission) {
            $merchant->givePermissionTo($merchantPermission);
        }

        $userPermissions = [
            'user-systems-management-access',
            'user-systems-management-create',
            'user-systems-management-read',
            'user-systems-management-update',
            'user-systems-management-delete',
        ];

        $userPermissionsGet = Permission::whereIn('name', $userPermissions)->get();

        foreach ($userPermissionsGet as $userPermission) {
            $user->givePermissionTo($userPermission);
        }

    }
}
