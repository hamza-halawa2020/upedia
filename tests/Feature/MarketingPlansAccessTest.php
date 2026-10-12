<?php

namespace Tests\Feature;

use App\Http\Middleware\SsoTokenAuthenticate;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class MarketingPlansAccessTest extends TestCase
{
    public function test_plan_edit_and_update_require_edit_permission(): void
    {
        Permission::create(['name' => 'marketing_plans_edit', 'guard_name' => 'web']);
        $user = User::create([
            'full_name' => 'Restricted user',
            'email' => 'restricted@example.test',
            'password' => bcrypt('test-password'),
        ]);
        $this->withoutMiddleware(SsoTokenAuthenticate::class);
        $this->actingAs($user);

        $this->get('/marketing/plans/1/edit')->assertForbidden();
        $this->put('/marketing/plans/1', [])->assertForbidden();
        $this->patch('/marketing/plans/1', [])->assertForbidden();
    }
}
