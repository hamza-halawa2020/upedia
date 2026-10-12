<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Marketing\Plans\Queries\ListCalendarEvents;
use Tests\TestCase;

class MarketingCalendarEventsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('marketing_plans', function (Blueprint $table) {
            $table->id();
            foreach (['name', 'platform', 'subject', 'status', 'type', 'month'] as $column) {
                $table->string($column)->nullable();
            }
            $table->date('publish_date')->nullable();
            $table->date('published_date')->nullable();
            $table->time('publish_time')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
        });
        DB::table('sm_staffs')->insert([
            'id' => 1, 'full_name' => 'Test Creator', 'first_name' => 'Test',
            'last_name' => 'Creator', 'email' => 'creator@example.test', 'user_id' => 1,
        ]);
    }

    public function test_events_keep_source_shape_and_staff_queries_do_not_grow_per_plan(): void
    {
        $this->insertPlan(1);
        DB::enableQueryLog();
        $events = app(ListCalendarEvents::class)->handle(['statuses' => 'approved', 'platforms' => 'facebook']);
        $initialQueries = count(DB::getQueryLog());
        $this->assertSame('2026-10-20T10:30:00', $events->first()['start']);
        $this->assertSame('#28a745', $events->first()['color']);
        $this->assertSame('Test Creator', $events->first()['extendedProps']['created_by']);

        for ($id = 2; $id <= 12; $id++) {
            $this->insertPlan($id);
        }
        DB::flushQueryLog();
        $events = app(ListCalendarEvents::class)->handle([]);
        $this->assertCount(12, $events);
        $this->assertSame($initialQueries, count(DB::getQueryLog()));
        $this->assertSame(2, $initialQueries);
        DB::disableQueryLog();
    }

    public function test_filters_exclude_unmatched_events_and_missing_staff_is_safe(): void
    {
        $this->insertPlan(1);
        DB::table('marketing_plans')->insert([
            'id' => 2, 'name' => 'Other', 'status' => 'draft', 'platform' => 'youtube',
            'published_date' => '2026-10-21',
        ]);
        $events = app(ListCalendarEvents::class)->handle(['statuses' => 'draft', 'platforms' => 'youtube']);
        $this->assertCount(1, $events);
        $this->assertSame(2, $events->first()['id']);
        $this->assertSame('2026-10-21T00:00:00', $events->first()['start']);
        $this->assertSame('', $events->first()['extendedProps']['created_by']);
    }

    private function insertPlan(int $id): void
    {
        DB::table('marketing_plans')->insert([
            'id' => $id, 'name' => 'Plan '.$id, 'status' => 'approved',
            'platform' => 'facebook', 'publish_date' => '2026-10-20',
            'publish_time' => '10:30:00', 'created_by' => 1,
        ]);
    }
}
