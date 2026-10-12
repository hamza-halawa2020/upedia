<?php

namespace Modules\Marketing\Reports\Builders;

use Carbon\Carbon;


class ReportCharts
{
    public function makeBarChart(string $title, array $items, string $suffix = ''): array
    {
        return [
            'type' => 'bar',
            'title' => $title,
            'labels' => collect($items)->pluck('label')->all(),
            'series' => collect($items)->pluck('value')->all(),
            'urls' => collect($items)->pluck('url')->all(),
            'suffix' => $suffix,
        ];
    }

    public function makeLineChart(string $title, array $items): array
    {
        return [
            'type' => 'line',
            'title' => $title,
            'labels' => collect($items)->pluck('label')->all(),
            'series' => collect($items)->pluck('value')->all(),
            'urls' => collect($items)->pluck('url')->all(),
            'suffix' => '',
        ];
    }

    public function makeProgressList(array $items, ?int $max = null): array
    {
        $total = $max ?: max(collect($items)->sum('value'), 1);

        return collect($items)
            ->map(function ($item) use ($total) {
                $value = (int) ($item['value'] ?? 0);

                return [
                    'label' => $item['label'] ?? 'Unknown',
                    'value' => $value,
                    'percentage' => min(100, (int) round(($value / $total) * 100)),
                    'url' => $item['url'] ?? null,
                ];
            })
            ->values()
            ->all();
    }
}
