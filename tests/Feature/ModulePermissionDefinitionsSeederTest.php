<?php

namespace Tests\Feature;

use App\Queries\Readiness\RequiredModulePermissions;
use Database\Seeders\ModulePermissionDefinitionsSeeder;
use Tests\TestCase;

class ModulePermissionDefinitionsSeederTest extends TestCase
{
    public function test_definitions_are_idempotent_and_do_not_grant_roles(): void
    {
        $this->seed(ModulePermissionDefinitionsSeeder::class);
        $this->seed(ModulePermissionDefinitionsSeeder::class);
        $this->assertDatabaseCount('permissions', count(app(RequiredModulePermissions::class)->handle()));
        $this->assertDatabaseCount('role_has_permissions', 0);
        $this->assertDatabaseCount('model_has_permissions', 0);
    }
}
