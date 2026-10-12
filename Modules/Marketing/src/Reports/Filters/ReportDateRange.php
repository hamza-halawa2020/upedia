<?php

namespace Modules\Marketing\Reports\Filters;

use Carbon\Carbon;


class ReportDateRange
{
    public function resolveDateRange(array $filters): array
    {
        $today = now()->startOfDay();
        $defaultFrom = $today->copy()->subDays(29);

        $from = $this->parseDate($filters['from'] ?? null) ?? $defaultFrom;
        $to = $this->parseDate($filters['to'] ?? null) ?? $today;

        if ($from->gt($to)) {
            [$from, $to] = [$to, $from];
        }

        return [$from->startOfDay(), $to->startOfDay()];
    }

    public function parseDate(?string $value): ?Carbon
    {
        if (!$value) {
            return null;
        }

        try {
            return Carbon::createFromFormat('Y-m-d', $value)->startOfDay();
        } catch (\Throwable $e) {
            return null;
        }
    }
}
