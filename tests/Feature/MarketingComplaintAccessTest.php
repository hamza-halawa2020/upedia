<?php

namespace Tests\Feature;

use App\Http\Middleware\SsoTokenAuthenticate;
use App\Models\User;
use Modules\Marketing\Complaints\Http\Controllers\ComplaintController;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class MarketingComplaintAccessTest extends TestCase
{
    public function test_complaint_entry_points_reject_users_without_permissions(): void
    {
        foreach (['index', 'create', 'show', 'edit', 'destroy'] as $action) {
            Permission::create(['name' => 'marketing_complains_'.$action, 'guard_name' => 'web']);
        }
        $user = User::create([
            'full_name' => 'Restricted user', 'email' => 'complaint@example.test',
            'password' => bcrypt('test-password'),
        ]);
        $this->withoutMiddleware(SsoTokenAuthenticate::class);
        $this->actingAs($user);

        $this->get('/marketing/complains')->assertForbidden();
        $this->get('/marketing/complains/create')->assertForbidden();
        $this->post('/marketing/complains', [])->assertForbidden();
        $this->get('/marketing/leads/check?client_number=01000000000')->assertForbidden();
    }

    public function test_each_complaint_action_has_an_explicit_permission(): void
    {
        $middleware = app(ComplaintController::class)->getMiddleware();
        $expected = [
            'index' => ['index'], 'create' => ['create', 'store', 'checkLeads'],
            'show' => ['show'], 'edit' => ['edit', 'update'], 'destroy' => ['destroy'],
        ];
        foreach ($expected as $permission => $actions) {
            $entry = collect($middleware)->firstWhere('middleware', 'check.permission:marketing_complains_'.$permission);
            $this->assertNotNull($entry);
            $this->assertSame($actions, $entry['options']['only']);
        }
    }
}
