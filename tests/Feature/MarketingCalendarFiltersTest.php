<?php

namespace Tests\Feature;

use App\Models\MarketingPlan;
use Modules\Marketing\Plans\Filters\CalendarFilters;
use Tests\TestCase;

class MarketingCalendarFiltersTest extends TestCase
{
    public function test_calendar_filters_preserve_multiple_values(): void
    {
        $query = app(CalendarFilters::class)->apply(MarketingPlan::query(), [
            'statuses' => 'approved,pending-review',
            'platforms' => 'facebook,instagram',
        ]);

        $this->assertSame(['approved', 'pending-review', 'facebook', 'instagram'], $query->getBindings());
        $this->assertStringContainsString('"status" in (?, ?)', $query->toSql());
        $this->assertStringContainsString('"platform" in (?, ?)', $query->toSql());
    }

    public function test_empty_filters_leave_calendar_query_unrestricted(): void
    {
        $query = app(CalendarFilters::class)->apply(MarketingPlan::query(), [
            'statuses' => null,
            'platforms' => '',
        ]);

        $this->assertSame([], $query->getBindings());
        $this->assertSame(MarketingPlan::query()->toSql(), $query->toSql());
    }
}
