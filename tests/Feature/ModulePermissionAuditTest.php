<?php

namespace Tests\Feature;

use App\Queries\Readiness\RequiredModulePermissions;
use Tests\TestCase;

class ModulePermissionAuditTest extends TestCase
{
    public function test_audit_includes_any_permission_guards_and_never_creates_grants(): void
    {
        $names = app(RequiredModulePermissions::class)->handle();
        $this->assertContains('marketing_complains_edit', $names);
        $this->assertContains('it_tickets_edit', $names);
        $this->assertContains('notifications_config_manage', $names);
        $this->assertSame(count($names), count(array_unique($names)));
        $this->artisan('migration:audit-permissions')->assertFailed();
        $this->assertDatabaseCount('permissions', 0);
        $this->assertDatabaseCount('role_has_permissions', 0);
    }
}
