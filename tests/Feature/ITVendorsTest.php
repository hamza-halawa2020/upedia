<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\AssetAccessory;
use App\Models\Vendor;
use App\Notifications\BaseNotification;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Modules\IT\Vendors\Actions\DeleteVendor;
use Modules\IT\Vendors\Exports\VendorsExport;
use Modules\IT\Vendors\Queries\ListVendors;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ITVendorsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        Notification::fake();
        Schema::create('it_vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('location');
            $table->decimal('tax')->nullable();
            $table->decimal('shipping_cost')->nullable();
            $table->timestamps();
        });
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('it_vendors');
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

    public function test_guest_is_redirected_and_vendor_route_is_prefixed(): void
    {
        $this->assertSame('/it/vendors', route('it.vendors.index', [], false));
        $this->get('/it/vendors')->assertRedirect(route('auth.login'));
    }

    public function test_create_update_and_notification(): void
    {
        $user = $this->vendorUser();
        $this->actingAs($user)->post(route('it.vendors.store'), $this->data())
            ->assertRedirect(route('it.vendors.index'));
        $vendor = Vendor::sole();
        $this->put(route('it.vendors.update', $vendor->id), $this->data('Updated'))
            ->assertRedirect(route('it.vendors.index'));
        $this->assertDatabaseHas('it_vendors', ['id' => $vendor->id, 'name' => 'Updated']);
        Notification::assertSentTo($user, BaseNotification::class);
    }

    public function test_validation_and_edit_authorization(): void
    {
        $user = $this->vendorUser();
        $this->actingAs($user)->post(route('it.vendors.store'), ['name' => 'Test', 'tax' => -1])
            ->assertSessionHasErrors(['phone', 'location', 'tax']);
        $vendor = Vendor::create($this->data());
        $user->revokePermissionTo('it_vendors_edit');
        $this->put(route('it.vendors.update', $vendor->id), $this->data('Changed'))->assertForbidden();
        $this->assertSame('Supplier', $vendor->fresh()->name);
    }

    public function test_missing_vendor_and_invalid_export_format(): void
    {
        $this->actingAs($this->vendorUser())->get(route('it.vendors.show', 999))->assertNotFound();
        $this->get(route('it.vendors.export', ['format' => 'exe']))->assertSessionHasErrors('format');
    }

    public function test_downloads_are_available_and_require_permission(): void
    {
        $user = $this->vendorUser();
        Vendor::create($this->data());
        $this->actingAs($user)->get(route('it.vendors.export', ['format' => 'xlsx']))
            ->assertDownload('vendors.xlsx');
        $this->get(route('it.vendors.export', ['format' => 'csv']))->assertDownload('vendors.csv');
        $user->revokePermissionTo('it_vendors_index');
        $this->get(route('it.vendors.export'))->assertForbidden();
    }

    public function test_search_pagination_and_export_share_the_same_filters(): void
    {
        for ($index = 0; $index < 12; $index++) {
            Vendor::create($this->data('Supplier '.$index));
        }
        Vendor::create($this->data('Other'));
        DB::enableQueryLog();
        $vendors = app(ListVendors::class)->handle(['search' => 'Supplier', 'per_page' => 5]);
        $this->assertSame(12, $vendors->total());
        $this->assertCount(5, $vendors->items());
        foreach ($vendors as $vendor) {
            $this->assertStringContainsString('Supplier', $vendor->name);
        }
        $this->assertCount(2, DB::getQueryLog());
        DB::disableQueryLog();
        $export = new VendorsExport(['search' => 'Supplier']);
        $this->assertSame(12, $export->query()->count());
        $this->assertCount(count($export->headings()), $export->map($vendors->first()));
    }

    public function test_delete_is_bulk_and_preserves_unrelated_assets(): void
    {
        $other = $this->withAssets(1);
        $one = $this->withAssets(1);
        $many = $this->withAssets(12);
        DB::enableQueryLog();
        app(DeleteVendor::class)->handle($one->id, null);
        $count = count(DB::getQueryLog());
        DB::flushQueryLog();
        app(DeleteVendor::class)->handle($many->id, null);
        $this->assertCount($count, DB::getQueryLog());
        DB::disableQueryLog();
        $this->assertDatabaseHas('it_vendors', ['id' => $other->id]);
        $this->assertDatabaseCount('assets', 1);
        $this->assertDatabaseCount('asset_accessories', 1);
    }

    public function test_failed_delete_rolls_back_without_notification(): void
    {
        $vendor = $this->withAssets(1);
        DB::statement("CREATE TRIGGER block_delete BEFORE DELETE ON assets BEGIN SELECT RAISE(ABORT, 'blocked'); END");
        try {
            app(DeleteVendor::class)->handle($vendor->id, $this->vendorUser());
            $this->fail('Expected a constraint failure');
        } catch (QueryException) {
            $this->assertDatabaseCount('it_vendors', 1);
            $this->assertDatabaseCount('assets', 1);
            $this->assertDatabaseCount('asset_accessories', 1);
            Notification::assertNothingSent();
        }
    }

    private function vendorUser()
    {
        $user = $this->actingAsAdminWithPermissions();
        foreach (['index', 'create', 'show', 'edit', 'destroy'] as $action) {
            $user->givePermissionTo(Permission::create(['name' => 'it_vendors_'.$action, 'guard_name' => 'web']));
        }

        return $user;
    }

    private function data(string $name = 'Supplier'): array
    {
        return ['name' => $name, 'phone' => '0123456789', 'location' => 'Cairo', 'tax' => 5, 'shipping_cost' => 20];
    }

    private function withAssets(int $count): Vendor
    {
        $vendor = Vendor::create($this->data());
        for ($index = 0; $index < $count; $index++) {
            $asset = Asset::create(['vendor_id' => $vendor->id, 'name' => 'Asset '.$index]);
            AssetAccessory::create(['asset_id' => $asset->id, 'type' => 'keyboard']);
        }

        return $vendor;
    }
}
