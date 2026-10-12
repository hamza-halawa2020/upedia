<?php

namespace Modules\Marketing\Reports\Builders;

use Carbon\Carbon;
use Illuminate\Support\Collection;


class ReportMetrics
{
    public function countBy(Collection $items,string $field,array $labels = [],?callable $urlResolver = null): array {
        $counts = $items
            ->groupBy(function ($item) use ($field) {
                $value = data_get($item, $field);

                if ($value === null || $value === '') {
                    return 'unclassified';
                }

                return (string) $value;
            })
            ->map(fn (Collection $group) => $group->count())
            ->sortDesc();

        return $counts
            ->map(function ($count, $key) use ($labels, $urlResolver) {
                return [
                    'label' => $labels[$key] ?? $this->normalizeLabel($key),
                    'value' => $count,
                    'url' => $urlResolver ? $urlResolver($key) : null,
                ];
            })
            ->values()
            ->take(6)
            ->all();
    }

    public function countByDateRange(Collection $items,Carbon $from,Carbon $to,callable $dateResolver,?callable $urlResolver = null): array {
        $timeline = [];
        $cursor = $from->copy();

        while ($cursor->lte($to)) {
            $timeline[$cursor->toDateString()] = 0;
            $cursor->addDay();
        }

        foreach ($items as $item) {
            $date = $dateResolver($item);

            if (!$date) {
                continue;
            }

            try {
                $parsed = Carbon::parse($date)->toDateString();
            } catch (\Throwable $e) {
                continue;
            }

            if (array_key_exists($parsed, $timeline)) {
                $timeline[$parsed]++;
            }
        }

        return collect($timeline)
            ->map(function ($count, $date) use ($urlResolver) {
                return [
                    'label' => Carbon::parse($date)->format('M d'),
                    'value' => $count,
                    'url' => $urlResolver ? $urlResolver($date) : null,
                ];
            })
            ->values()
            ->all();
    }

    public function topStaff(Collection $items,callable $resolver,int $limit = 5,?callable $urlResolver = null): array {
        $grouped = $items
            ->map(function ($item) use ($resolver) {
                $staff = $resolver($item);

                if (!$staff) {
                    return null;
                }

                return [
                    'id' => $staff->id,
                    'label' => trim(
                        $staff->full_name
                        ?? (($staff->first_name ?? '') . ' ' . ($staff->last_name ?? ''))
                    ),
                ];
            })
            ->filter()
            ->groupBy('id')
            ->map(function (Collection $group) use ($urlResolver) {
                $first = $group->first();

                return [
                    'label' => $first['label'],
                    'value' => $group->count(),
                    'url' => $urlResolver ? $urlResolver($first['id']) : null,
                ];
            })
            ->sortByDesc('value')
            ->take($limit);

        return $grouped->values()->all();
    }

    public function averageHandlingHours(Collection $complains): string
    {
        $hours = $complains
            ->where('status', 'solved')
            ->filter(fn ($complain) => $complain->created_at && $complain->updated_at)
            ->map(fn ($complain) => $complain->created_at->diffInHours($complain->updated_at));

        if ($hours->isEmpty()) {
            return 'N/A';
        }

        return round($hours->avg(), 1) . 'h';
    }

    public function percentage(int $value, int $total): int
    {
        if ($total === 0) {
            return 0;
        }

        return (int) round(($value / $total) * 100);
    }

    public function normalizeLabel(string $value): string
    {
        return ucwords(str_replace(['-', '_'], ' ', $value));
    }
}
