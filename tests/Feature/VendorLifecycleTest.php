<?php

namespace Tests\Feature;

use App\Http\Middleware\SsoTokenAuthenticate;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Notifications\Actions\NotifyActor;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class VendorLifecycleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('it_vendors', function (Blueprint $table) {
            $table->id();
            foreach (['name', 'phone', 'location'] as $column) {
                $table->string($column);
            }
            $table->decimal('tax')->nullable();
            $table->decimal('shipping_cost')->nullable();
            $table->timestamps();
        });
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
        });
        Schema::create('asset_accessories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
        });
        $this->withoutMiddleware(SsoTokenAuthenticate::class);
        $this->mock(NotifyActor::class)->shouldReceive('handle')->andReturnNull();
        foreach (['create', 'edit', 'destroy'] as $action) {
            Permission::create(['name' => 'it_vendors_'.$action, 'guard_name' => 'web']);
        }
        $this->actingAs(User::create(['full_name' => 'Tester', 'email' => 'vendors@example.test', 'password' => bcrypt('test')]));
    }

    public function test_http_lifecycle_only_deletes_the_selected_vendors_assets(): void
    {
        auth()->user()->givePermissionTo(['it_vendors_create', 'it_vendors_edit', 'it_vendors_destroy']);
        $this->post('/it/vendors', $this->data())->assertRedirect();
        $id = DB::table('it_vendors')->value('id');
        $this->assertNotNull($id);
        $this->put('/it/vendors/'.$id, $this->data(['name' => 'Updated', 'tax' => 15]))->assertRedirect();
        $this->assertDatabaseHas('it_vendors', ['id' => $id, 'name' => 'Updated', 'tax' => 15]);
        $other = DB::table('it_vendors')->insertGetId($this->data(['name' => 'Other']));
        DB::table('assets')->insert([['id' => 1, 'vendor_id' => $id], ['id' => 2, 'vendor_id' => $other]]);
        DB::table('asset_accessories')->insert([['id' => 1, 'asset_id' => 1], ['id' => 2, 'asset_id' => 2]]);
        $this->delete('/it/vendors/'.$id)->assertRedirect();
        $this->assertDatabaseMissing('it_vendors', ['id' => $id]);
        $this->assertDatabaseMissing('assets', ['id' => 1]);
        $this->assertDatabaseMissing('asset_accessories', ['id' => 1]);
        $this->assertDatabaseHas('it_vendors', ['id' => $other]);
        $this->assertDatabaseHas('assets', ['id' => 2]);
        $this->assertDatabaseHas('asset_accessories', ['id' => 2]);
    }

    public function test_invalid_create_and_update_preserve_database_state(): void
    {
        auth()->user()->givePermissionTo(['it_vendors_create', 'it_vendors_edit']);
        $this->postJson('/it/vendors', $this->data(['tax' => -1, 'shipping_cost' => -1, 'phone' => '']))
            ->assertUnprocessable()->assertJsonValidationErrors(['tax', 'shipping_cost', 'phone']);
        $this->assertDatabaseCount('it_vendors', 0);
        $id = DB::table('it_vendors')->insertGetId($this->data());
        $this->putJson('/it/vendors/'.$id, $this->data(['name' => 'Changed', 'shipping_cost' => -5]))->assertUnprocessable();
        $this->assertDatabaseHas('it_vendors', ['id' => $id, 'name' => 'Supplier', 'shipping_cost' => 20]);
    }

    public function test_user_without_permissions_cannot_mutate_vendors(): void
    {
        $id = DB::table('it_vendors')->insertGetId($this->data());
        $this->post('/it/vendors', $this->data())->assertForbidden();
        $this->put('/it/vendors/'.$id, $this->data(['name' => 'Changed']))->assertForbidden();
        $this->delete('/it/vendors/'.$id)->assertForbidden();
        $this->assertDatabaseCount('it_vendors', 1);
        $this->assertDatabaseHas('it_vendors', ['id' => $id, 'name' => 'Supplier']);
    }

    private function data(array $overrides = []): array
    {
        return array_replace(['name' => 'Supplier', 'phone' => '01000000000', 'location' => 'Cairo', 'tax' => 10, 'shipping_cost' => 20], $overrides);
    }
}
