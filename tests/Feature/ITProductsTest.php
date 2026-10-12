<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\AssetAccessory;
use App\Models\ItProduct;
use Spatie\Permission\Models\Permission;
use App\Notifications\BaseNotification;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Modules\IT\Products\Actions\DeleteProduct;
use Modules\IT\Products\Queries\ListProducts;
use Tests\TestCase;

class ITProductsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        $this->assertSame('sqlite', DB::connection()->getDriverName());
        Notification::fake();
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('asset_accessories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets');
            $table->string('type');
            $table->timestamps();
        });
    }

    public function test_it_routes_have_unique_domain_names_and_require_authentication(): void
    {
        $this->assertSame('/it/products', route('it.products.index', [], false));
        $this->get('/it/products')->assertRedirect(route('auth.login'));
    }

    public function test_create_and_update_use_the_it_table_and_notify_the_actor(): void
    {
        $user = $this->productUser();
        $this->actingAs($user)->post(route('it.products.store'), ['name' => 'Laptop'])
            ->assertRedirect(route('it.products.index'));
        $product = ItProduct::sole();
        $this->assertSame('products', $product->getTable());
        $this->actingAs($user)->put(route('it.products.update', $product->id), ['name' => 'Monitor'])
            ->assertRedirect(route('it.products.index'));
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Monitor']);
        Notification::assertSentTo($user, BaseNotification::class, function ($notification) {
            return $notification->action_url === route('it.products.index');
        });
    }

    public function test_invalid_names_are_rejected_without_creating_a_product(): void
    {
        $this->actingAs($this->productUser())->post(route('it.products.store'), ['name' => ''])
            ->assertSessionHasErrors('name');
        $this->assertDatabaseCount('products', 0);
        Notification::assertNothingSent();
    }

    public function test_edit_permission_is_required_for_update(): void
    {
        $user = $this->productUser();
        $user->revokePermissionTo('it_products_edit');
        $product = ItProduct::create(['name' => 'Laptop']);
        $this->actingAs($user)->put(route('it.products.update', $product->id), ['name' => 'Changed'])
            ->assertForbidden();
        $this->assertSame('Laptop', $product->fresh()->name);
    }

    public function test_missing_product_returns_not_found(): void
    {
        $this->actingAs($this->productUser())->get(route('it.products.show', 999))->assertNotFound();
    }

    public function test_search_is_paginated_and_uses_one_query_pair(): void
    {
        for ($index = 0; $index < 12; $index++) {
            ItProduct::create(['name' => 'Laptop '.$index]);
        }
        ItProduct::create(['name' => 'Monitor']);
        DB::enableQueryLog();
        $products = app(ListProducts::class)->handle(['search' => 'Laptop']);
        $this->assertSame(12, $products->total());
        $this->assertCount(10, $products->items());
        foreach ($products as $product) {
            $this->assertStringContainsString('Laptop', $product->name);
        }
        $this->assertCount(2, DB::getQueryLog());
        DB::disableQueryLog();
    }

    public function test_delete_removes_only_dependent_records_with_bounded_queries(): void
    {
        $other = $this->productWithAssets(1);
        $one = $this->productWithAssets(1);
        $many = $this->productWithAssets(12);
        DB::enableQueryLog();
        app(DeleteProduct::class)->handle($one->id, null);
        $oneCount = count(DB::getQueryLog());
        DB::flushQueryLog();
        app(DeleteProduct::class)->handle($many->id, null);
        $this->assertCount($oneCount, DB::getQueryLog());
        DB::disableQueryLog();
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', ['id' => $other->id]);
        $this->assertDatabaseCount('assets', 1);
        $this->assertDatabaseCount('asset_accessories', 1);
    }

    public function test_delete_failure_rolls_back_accessories_and_does_not_notify(): void
    {
        $product = $this->productWithAssets(1);
        DB::statement("CREATE TRIGGER block_asset_delete BEFORE DELETE ON assets BEGIN SELECT RAISE(ABORT, 'blocked'); END");
        try {
            app(DeleteProduct::class)->handle($product->id, $this->productUser());
            $this->fail('Expected a database constraint failure');
        } catch (QueryException) {
            $this->assertDatabaseCount('products', 1);
            $this->assertDatabaseCount('assets', 1);
            $this->assertDatabaseCount('asset_accessories', 1);
            Notification::assertNothingSent();
        }
    }

    private function productUser()
    {
        $user = $this->actingAsAdminWithPermissions();
        foreach (['index', 'create', 'show', 'edit', 'destroy'] as $action) {
            $permission = Permission::create(['name' => 'it_products_'.$action, 'guard_name' => 'web']);
            $user->givePermissionTo($permission);
        }

        return $user;
    }

    private function productWithAssets(int $count): ItProduct
    {
        $product = ItProduct::create(['name' => 'Laptop']);
        for ($index = 0; $index < $count; $index++) {
            $asset = Asset::create(['product_id' => $product->id, 'name' => 'Asset '.$index]);
            AssetAccessory::create(['asset_id' => $asset->id, 'type' => 'keyboard']);
        }

        return $product;
    }
}
