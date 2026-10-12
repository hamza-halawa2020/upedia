<?php

namespace Modules\IT\Reports\Queries;

use Modules\IT\Reports\Builders\ReportLinks;
use Modules\IT\Reports\Filters\ReportWindow;

class BuildReport
{
    public function __construct(private readonly ReportWindow $window, private readonly ReportTotals $totals,
        private readonly ReportClassification $classification, private readonly ReportResolution $resolution,
        private readonly ReportPatterns $patterns, private readonly ReportCharts $charts) {}

    public function handle(array $criteria): array
    {
        [$start, $end, $range] = $this->window->resolveFilterWindow($criteria['range'] ?? 'month',
            $criteria['date_from'] ?? null, $criteria['date_to'] ?? null);

        $departmentPerformance = $this->classification->getDepartmentPerformance($start, $end);

        return ['links' => app(ReportLinks::class)->handle($start, $end, $departmentPerformance->first()?->id),
            'topDepartment' => $departmentPerformance->first(), 'start' => $start, 'end' => $end, 'range' => $range,
            'totalStats' => $this->totals->getTotals($start, $end),
            'classification' => $this->classification->getClassification($start, $end),
            'departmentPerformance' => $departmentPerformance,
            'resolutionMetrics' => $this->resolution->getResolutionMetrics($start, $end),
            'resolutionDescriptions' => $this->resolution->getResolutionDescriptions($start, $end),
            'recurringIssues' => $this->classification->getRecurringIssues($start, $end),
            'timePatterns' => $this->patterns->getTimePatterns($start, $end),
            'internetPattern' => $this->patterns->getInternetPattern($start, $end),
            'reopenedIssues' => $this->patterns->getReopenedIssues($start),
            'realTimeData' => $this->totals->getRealTimeData(),
            'charts' => $this->charts->getChartData($start, $end, $range)];
    }
}
