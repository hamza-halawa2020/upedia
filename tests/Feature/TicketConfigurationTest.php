<?php

namespace Tests\Feature;

use App\Models\TicketCategory;
use App\Models\TicketItem;
use App\Models\TicketPriority;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\IT\TicketConfiguration\Catalog;
use Modules\IT\TicketConfiguration\Queries\CatalogRecords;
use Tests\TestCase;

class TicketConfigurationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        Schema::create('ticket_priorities', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->integer('sla_hours'); $table->timestamps();
        });
        Schema::create('ticket_categories', function (Blueprint $table) {
            $table->id(); $table->string('name');
            $table->foreignId('parent_id')->nullable()->constrained('ticket_categories')->cascadeOnDelete();
            $table->foreignId('priority_id')->nullable()->constrained('ticket_priorities')->nullOnDelete();
            $table->timestamps();
        });
        Schema::create('ticket_items', function (Blueprint $table) {
            $table->id(); $table->string('name')->unique();
            $table->foreignId('ticket_subcategory_id')->constrained('ticket_categories')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function test_catalog_routes_require_authentication(): void
    {
        foreach (Catalog::cases() as $catalog) {
            $this->get('/it/'.$catalog->value)->assertRedirect(route('auth.login'));
        }
    }

    public function test_category_item_and_priority_creation_and_update(): void
    {
        $this->actingAs($this->actingAsAdminWithPermissions());
        $this->post('/it/ticket-priorities', ['name' => 'High', 'sla_hours' => 4])->assertRedirect();
        $this->post('/it/ticket-categories', ['name' => 'Hardware', 'priority_id' => TicketPriority::sole()->id])->assertRedirect();
        $parent = TicketCategory::sole();
        $this->post('/it/ticket-categories', ['name' => 'Laptop', 'parent_id' => $parent->id])->assertRedirect();
        $subcategory = TicketCategory::whereNotNull('parent_id')->sole();
        $this->post('/it/ticket-items', ['name' => 'Screen', 'ticket_subcategory_id' => $subcategory->id])->assertRedirect();
        $item = TicketItem::sole();
        $this->put('/it/ticket-items/'.$item->id, ['name' => 'Screen', 'ticket_subcategory_id' => $subcategory->id])->assertRedirect();
        $this->assertDatabaseHas('ticket_items', ['name' => 'Screen']);
        $this->get('/it/ticket-priorities/999')->assertNotFound();
    }

    public function test_invalid_category_hierarchy_and_item_parent_are_rejected(): void
    {
        $this->actingAs($this->actingAsAdminWithPermissions());
        $parent = TicketCategory::create(['name' => 'Parent']);
        $child = TicketCategory::create(['name' => 'Child', 'parent_id' => $parent->id]);
        $this->put('/it/ticket-categories/'.$parent->id, ['name' => 'Parent', 'parent_id' => $parent->id])
            ->assertSessionHasErrors('parent_id');
        $this->post('/it/ticket-categories', ['name' => 'Grandchild', 'parent_id' => $child->id])
            ->assertSessionHasErrors('parent_id');
        $this->post('/it/ticket-items', ['name' => 'Item', 'ticket_subcategory_id' => $parent->id])
            ->assertSessionHasErrors('ticket_subcategory_id');
        $this->post('/it/ticket-priorities', ['name' => 'Invalid', 'sla_hours' => 0])->assertSessionHasErrors('sla_hours');
    }

    public function test_list_eager_loads_nested_category_without_per_row_queries(): void
    {
        $parent = TicketCategory::create(['name' => 'Parent']);
        $child = TicketCategory::create(['name' => 'Child', 'parent_id' => $parent->id]);
        for ($i = 0; $i < 10; $i++) {
            TicketItem::create(['name' => 'Item '.$i, 'ticket_subcategory_id' => $child->id]);
        }
        DB::enableQueryLog();
        $items = app(CatalogRecords::class)->list(Catalog::Items, ['search' => 'Item']);
        foreach ($items as $item) {
            $this->assertSame('Parent', $item->subcategory->parent->name);
        }
        $this->assertCount(4, DB::getQueryLog());
        DB::disableQueryLog();
    }
}
