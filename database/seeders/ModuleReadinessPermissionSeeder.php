<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ModuleReadinessPermissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $admin = Role::where('name', 'Super admin')->where('guard_name', 'web')->firstOrFail();
            foreach (['it_expenses_update_status', 'it_purchase_update_status', 'notifications_config_manage'] as $name) {
                $permission = Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
                $admin->givePermissionTo($permission);
            }
        });
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
