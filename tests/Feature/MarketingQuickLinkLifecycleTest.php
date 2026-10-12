<?php

namespace Tests\Feature;

use App\Http\Middleware\SsoTokenAuthenticate;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Marketing\QuickLinks\Actions\CreateQuickLink;
use Modules\Marketing\QuickLinks\Actions\UpdateQuickLink;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class MarketingQuickLinkLifecycleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('quick_links', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('link');
            $table->boolean('is_active');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
        Schema::create('quick_link_departments', function (Blueprint $table) {
            $table->foreignId('quick_link_id')->constrained('quick_links');
            $table->foreignId('department_id')->constrained('sm_human_departments');
        });
        DB::table('sm_human_departments')->insert([['id' => 1, 'name' => 'Marketing'], ['id' => 2, 'name' => 'IT']]);
        foreach (['create', 'destroy'] as $action) {
            Permission::create(['name' => 'marketing_quickLinks_'.$action, 'guard_name' => 'web']);
        }
        $this->withoutMiddleware(SsoTokenAuthenticate::class);
        $this->actingAs(User::create(['full_name' => 'Tester', 'email' => 'links@example.test', 'password' => bcrypt('test')]));
    }

    public function test_http_lifecycle_syncs_departments_and_cleans_pivot(): void
    {
        auth()->user()->givePermissionTo(['marketing_quickLinks_create', 'marketing_quickLinks_destroy']);
        $this->postJson('/marketing/quick-links', $this->data())->assertSuccessful();
        $id = DB::table('quick_links')->value('id');
        $this->assertDatabaseHas('quick_links', ['id' => $id, 'created_by' => auth()->id(), 'is_active' => 1]);
        $this->assertDatabaseHas('quick_link_departments', ['quick_link_id' => $id, 'department_id' => 1]);
        $this->putJson('/marketing/quick-links/'.$id, $this->data(['name' => 'Updated', 'department_ids' => [2], 'is_active' => false]))->assertSuccessful();
        $this->assertDatabaseHas('quick_links', ['id' => $id, 'name' => 'Updated', 'is_active' => 0]);
        $this->assertDatabaseMissing('quick_link_departments', ['quick_link_id' => $id, 'department_id' => 1]);
        $this->assertDatabaseHas('quick_link_departments', ['quick_link_id' => $id, 'department_id' => 2]);
        $this->deleteJson('/marketing/quick-links/'.$id)->assertSuccessful();
        $this->assertDatabaseCount('quick_links', 0);
        $this->assertDatabaseCount('quick_link_departments', 0);
    }

    public function test_permissions_and_validation_prevent_writes(): void
    {
        $this->postJson('/marketing/quick-links', $this->data())->assertForbidden();
        auth()->user()->givePermissionTo('marketing_quickLinks_create');
        $this->postJson('/marketing/quick-links', $this->data(['link' => 'javascript:alert(1)', 'department_ids' => [999]]))
            ->assertUnprocessable()->assertJsonValidationErrors(['link', 'department_ids.0']);
        $this->assertDatabaseCount('quick_links', 0);
    }

    public function test_failed_department_sync_rolls_back_create_and_update(): void
    {
        try {
            app(CreateQuickLink::class)->handle($this->data(['department_ids' => [999]]));
            $this->fail('Expected a foreign key failure.');
        } catch (QueryException $exception) {
            $this->assertDatabaseCount('quick_links', 0);
        }
        $link = app(CreateQuickLink::class)->handle($this->data());
        try {
            app(UpdateQuickLink::class)->handle($link, $this->data(['name' => 'Partial', 'department_ids' => [999]]));
            $this->fail('Expected a foreign key failure.');
        } catch (QueryException $exception) {
            $this->assertDatabaseHas('quick_links', ['id' => $link->id, 'name' => 'Portal']);
            $this->assertDatabaseHas('quick_link_departments', ['quick_link_id' => $link->id, 'department_id' => 1]);
        }
    }

    private function data(array $overrides = []): array
    {
        return array_replace(['name' => 'Portal', 'link' => 'https://example.test', 'is_active' => true, 'department_ids' => [1]], $overrides);
    }
}
