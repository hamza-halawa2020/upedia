<?php

namespace Tests\Feature;

use Database\Seeders\ModuleReadinessPermissionSeeder;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ModuleReadinessPermissionSeederTest extends TestCase
{
    public function test_repeated_seeding_only_grants_new_permissions_to_super_admin(): void
    {
        $admin = Role::create(['name' => 'Super admin', 'guard_name' => 'web']);
        $other = Role::create(['name' => 'IT Staff', 'guard_name' => 'web']);
        $this->seed(ModuleReadinessPermissionSeeder::class);
        $this->seed(ModuleReadinessPermissionSeeder::class);
        $this->assertDatabaseCount('permissions', 3);
        $this->assertDatabaseCount('role_has_permissions', 3);
        $this->assertCount(3, $admin->fresh()->permissions);
        $this->assertCount(0, $other->fresh()->permissions);
    }
}
