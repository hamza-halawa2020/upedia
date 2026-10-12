<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Modules\IT\Tickets\Services\BusinessMinutes;
use Tests\TestCase;

class BusinessMinutesTest extends TestCase
{
    public function test_signed_minutes_exclude_weekends_and_nonworking_hours(): void
    {
        $service = app(BusinessMinutes::class);
        $from = Carbon::parse('2026-10-08 15:30:00');
        $to = Carbon::parse('2026-10-11 08:30:00');
        $this->assertSame(60, $service->between($from, $to, 8, 16));
        $this->assertSame(-60, $service->between($to, $from, 8, 16));
        $this->assertFalse($service->isWorking(Carbon::parse('2026-10-09 10:00:00'), 8, 16));
        $this->assertFalse($service->isWorking(Carbon::parse('2026-10-11 16:00:00'), 8, 16));
        $this->assertTrue($service->isWorking($to, 8, 16));
    }

    public function test_invalid_hours_fail_instead_of_looping(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        app(BusinessMinutes::class)->between(Carbon::now(), Carbon::now(), 16, 8);
    }
}
