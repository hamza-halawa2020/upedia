<?php

namespace Modules\IT\Reports\Queries;

use App\Models\Ticket;
use Carbon\Carbon;

class ReportCharts
{
    public function __construct(private readonly ReportClassification $reportClassification) {}

    public function getChartData(Carbon $start, Carbon $end, string $range): array
    {
        if ($range === 'day') {
            $trend = Ticket::query()
                ->selectRaw("DATE_FORMAT(created_at, '%H:00') as label")
                ->selectRaw('HOUR(created_at) as sort_order')
                ->selectRaw('COUNT(*) as total')
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('label', 'sort_order')
                ->orderBy('sort_order')
                ->get();
        } else {
            $trend = Ticket::query()
                ->selectRaw("DATE_FORMAT(created_at, '%b %d') as label")
                ->selectRaw('DATE(created_at) as sort_order')
                ->selectRaw('COUNT(*) as total')
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('label', 'sort_order')
                ->orderBy('sort_order')
                ->get();
        }

        $categoryChart = $this->reportClassification->getClassification($start, $end)->take(6);
        $departmentChart = $this->reportClassification->getDepartmentPerformance($start, $end)->take(6);

        return [
            'trend' => [
                'labels' => $trend->pluck('label'),
                'values' => $trend->pluck('total'),
            ],
            'categories' => [
                'labels' => $categoryChart->pluck('name'),
                'values' => $categoryChart->pluck('total'),
            ],
            'departments' => [
                'labels' => $departmentChart->pluck('name'),
                'values' => $departmentChart->pluck('total_tickets'),
            ],
        ];
    }
}
