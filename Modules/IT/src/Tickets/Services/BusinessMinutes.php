<?php

namespace Modules\IT\Tickets\Services;

use Carbon\Carbon;

class BusinessMinutes
{
    public function isWorking(Carbon $time, int $start, int $end): bool
    {
        $this->validate($start, $end);

        return ! in_array($time->dayOfWeek, [Carbon::FRIDAY, Carbon::SATURDAY])
            && $time->hour >= $start && $time->hour < $end;
    }

    public function between(Carbon $from, Carbon $to, int $start, int $end): int
    {
        $this->validate($start, $end);
        if ($from->greaterThan($to)) {
            return -$this->between($to, $from, $start, $end);
        }
        $minutes = 0;
        for ($day = $from->copy()->startOfDay(); $day->lessThanOrEqualTo($to); $day->addDay()) {
            if (in_array($day->dayOfWeek, [Carbon::FRIDAY, Carbon::SATURDAY])) {
                continue;
            }
            $opening = $day->copy()->setTime($start, 0)->max($from);
            $closing = $day->copy()->setTime($end, 0)->min($to);
            if ($opening->lessThan($closing)) {
                $minutes += (int) $opening->diffInMinutes($closing);
            }
        }

        return $minutes;
    }

    private function validate(int $start, int $end): void
    {
        if ($start < 0 || $end > 24 || $start >= $end) {
            throw new \InvalidArgumentException('Invalid working hours.');
        }
    }
}
