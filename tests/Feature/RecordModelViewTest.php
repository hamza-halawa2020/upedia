<?php

namespace Tests\Feature;

use App\Actions\Views\RecordModelView;
use App\Models\Ticket;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class RecordModelViewTest extends TestCase
{
    public function test_view_recording_is_atomic_and_does_not_change_ticket_update_time(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('views_count')->default(0);
            $table->timestamps();
        });
        Schema::create('views', function (Blueprint $table) {
            $table->id();
            $table->morphs('viewable');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
        $ticket = Ticket::create(['updated_at' => '2026-01-01 10:00:00']);
        $request = Request::create('/it/tickets/1', 'GET', server: ['REMOTE_ADDR' => '127.0.0.1']);
        app(RecordModelView::class)->handle($ticket, $request);
        $this->assertSame(1, $ticket->fresh()->views_count);
        $this->assertSame('2026-01-01 10:00:00', $ticket->fresh()->updated_at->format('Y-m-d H:i:s'));
        $this->assertDatabaseHas('views', ['viewable_id' => $ticket->id, 'ip_address' => '127.0.0.1']);
        DB::beginTransaction();
        app(RecordModelView::class)->handle($ticket, $request);
        DB::rollBack();
        $this->assertSame(1, $ticket->fresh()->views_count);
        $this->assertDatabaseCount('views', 1);
    }
}
