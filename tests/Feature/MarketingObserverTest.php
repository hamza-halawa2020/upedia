<?php

namespace Tests\Feature;

use App\Models\QuickLink;
use App\Services\Notifications\MarketingNotificationService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MarketingObserverTest extends TestCase
{
    public function test_registered_observers_run_only_after_commit_and_skip_rollback(): void
    {
        Schema::create('quick_links', function (Blueprint $table) {
            $table->id(); $table->string('title')->nullable(); $table->timestamps();
        });
        $service = $this->mock(MarketingNotificationService::class);
        $service->shouldReceive('quickLinkChanged')->once()->withArgs(fn ($link, $event) => $event === 'created');
        DB::transaction(fn () => QuickLink::create(['title' => 'Committed']));
        DB::beginTransaction();
        QuickLink::create(['title' => 'Rolled back']);
        DB::rollBack();
        $this->assertDatabaseCount('quick_links', 1);
    }
}
