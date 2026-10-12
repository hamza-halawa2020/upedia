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

class ProductLifecycleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
        });
        Schema::create('asset_accessories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
        });
        $this->withoutMiddleware(SsoTokenAuthenticate::class);
        $this->mock(NotifyActor::class)->shouldReceive('handle')->andReturnNull();
        foreach (['create', 'edit', 'destroy'] as $action) {
            Permission::create(['name' => 'it_products_'.$action, 'guard_name' => 'web']);
        }
    }

    public function test_authorized_product_lifecycle_preserves_other_products_and_assets(): void
    {
        $user = $this->user();
        $user->givePermissionTo(['it_products_create', 'it_products_edit', 'it_products_destroy']);
        $this->actingAs($user);
        $this->post('/it/products', ['name' => 'Laptop'])->assertRedirect();
        $id = DB::table('products')->where('name', 'Laptop')->value('id');
        $this->assertNotNull($id);
        $this->put('/it/products/'.$id, ['name' => 'Workstation'])->assertRedirect();
        $this->assertDatabaseHas('products', ['id' => $id, 'name' => 'Workstation']);
        $other = DB::table('products')->insertGetId(['name' => 'Other']);
        DB::table('assets')->insert([['id' => 1, 'product_id' => $id], ['id' => 2, 'product_id' => $other]]);
        DB::table('asset_accessories')->insert([['id' => 1, 'asset_id' => 1], ['id' => 2, 'asset_id' => 2]]);
        $this->delete('/it/products/'.$id)->assertRedirect();
        $this->assertDatabaseMissing('products', ['id' => $id]);
        $this->assertDatabaseMissing('assets', ['id' => 1]);
        $this->assertDatabaseMissing('asset_accessories', ['id' => 1]);
        $this->assertDatabaseHas('products', ['id' => $other]);
        $this->assertDatabaseHas('assets', ['id' => 2]);
        $this->assertDatabaseHas('asset_accessories', ['id' => 2]);
    }

    public function test_invalid_names_do_not_write_products(): void
    {
        $user = $this->user();
        $user->givePermissionTo('it_products_create');
        $this->actingAs($user);
        $this->postJson('/it/products', ['name' => ''])->assertUnprocessable()->assertJsonValidationErrors('name');
        $this->postJson('/it/products', ['name' => str_repeat('a', 256)])->assertUnprocessable();
        $this->assertDatabaseCount('products', 0);
    }

    public function test_restricted_user_cannot_mutate_products(): void
    {
        DB::table('products')->insert(['id' => 1, 'name' => 'Protected']);
        $this->actingAs($this->user());
        $this->post('/it/products', ['name' => 'Unauthorized'])->assertForbidden();
        $this->put('/it/products/1', ['name' => 'Unauthorized'])->assertForbidden();
        $this->delete('/it/products/1')->assertForbidden();
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', ['id' => 1, 'name' => 'Protected']);
    }

    private function user(): User
    {
        return User::create(['full_name' => 'Tester', 'email' => 'products@example.test', 'password' => bcrypt('test')]);
    }
}
