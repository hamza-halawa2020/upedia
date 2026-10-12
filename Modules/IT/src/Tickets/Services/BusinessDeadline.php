<?php

namespace Modules\IT\Tickets\Services;

use Carbon\Carbon;

class BusinessDeadline
{
    public function add(Carbon $date, int $minutes, int $start = 8, int $end = 16): Carbon
    {
        if ($start < 0 || $end > 24 || $start >= $end) {
            throw new \InvalidArgumentException('Invalid working hours.');
        }
        $current = $date->copy();
        while ($minutes > 0) {
            if (in_array($current->dayOfWeek, [Carbon::FRIDAY, Carbon::SATURDAY]) || $current->hour >= $end) {
                do {
                    $current->addDay()->setTime($start, 0);
                } while (in_array($current->dayOfWeek, [Carbon::FRIDAY, Carbon::SATURDAY]));
            }
            if ($current->hour < $start) {
                $current->setTime($start, 0);
            }
            $finish = $current->copy()->setTime($end, 0);
            $available = (int) $current->diffInMinutes($finish);
            if ($minutes <= $available) {
                return $current->addMinutes($minutes);
            }
            $minutes -= $available;
            $current = $finish;
        }

        return $current;
    }
}
