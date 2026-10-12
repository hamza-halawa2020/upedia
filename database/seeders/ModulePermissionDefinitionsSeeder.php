<?php

namespace Database\Seeders;

use App\Queries\Readiness\RequiredModulePermissions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class ModulePermissionDefinitionsSeeder extends Seeder
{
    public function run(): void
    {
        foreach (app(RequiredModulePermissions::class)->handle() as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
