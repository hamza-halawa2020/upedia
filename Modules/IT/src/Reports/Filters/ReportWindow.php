<?php

namespace Modules\IT\Reports\Filters;

use Carbon\Carbon;

class ReportWindow
{
    public function resolveRangeWindow(string $range): array
    {
        return match ($range) {
            'day' => [now()->startOfDay(), now()->endOfDay()],
            'week' => [now()->subDays(6)->startOfDay(), now()->endOfDay()],
            default => [now()->subDays(29)->startOfDay(), now()->endOfDay()],
        };
    }

    public function resolveFilterWindow(string $range, ?string $dateFrom, ?string $dateTo): array
    {
        if ($dateFrom || $dateTo) {
            $start = $dateFrom
                ? Carbon::parse($dateFrom)->startOfDay()
                : Carbon::parse($dateTo)->startOfDay();

            $end = $dateTo
                ? Carbon::parse($dateTo)->endOfDay()
                : Carbon::parse($dateFrom)->endOfDay();

            if ($start->greaterThan($end)) {
                [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
            }

            return [$start, $end, 'custom'];
        }

        [$start, $end] = $this->resolveRangeWindow($range);

        return [$start, $end, $range];
    }
}
