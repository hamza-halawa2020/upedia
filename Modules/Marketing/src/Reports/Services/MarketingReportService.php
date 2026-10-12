<?php

namespace Modules\Marketing\Reports\Services;

use Carbon\Carbon;

use Modules\Marketing\Reports\Filters\ReportDateRange;
use Modules\Marketing\Reports\Queries\ReportData;
use Modules\Marketing\Reports\Builders\ReportSummary;
use Modules\Marketing\Reports\Builders\ReportSections;

class MarketingReportService
{
    public function __construct(
        private readonly ReportDateRange $dates,
        private readonly ReportData $data,
        private readonly ReportSummary $summary,
        private readonly ReportSections $sections
    ) {}

    public function build(array $filters = []): array
    {
        [$from, $to] = $this->dates->resolveDateRange($filters);

        $plans = $this->data->getPlans($from, $to);
        $complains = $this->data->getComplains($from, $to);
        $leads = $this->data->getLeads($from, $to);

        $summary = $this->summary->buildSummary($plans, $complains, $leads, $from, $to);

        return [
            'title' => 'Marketing Reports',
            'subTitle' => 'Dashboard',
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
            'rangeLabel' => $from->format('M d, Y') . ' - ' . $to->format('M d, Y'),
            'summaryCards' => $summary['cards'],
            'sections' => $this->sections->build($plans, $complains, $leads, $from, $to, $summary),
            'quickRanges' => [
                'today' => [
                    'from' => now()->toDateString(),
                    'to' => now()->toDateString(),
                ],
                'last7' => [
                    'from' => now()->subDays(6)->toDateString(),
                    'to' => now()->toDateString(),
                ],
                'last30' => [
                    'from' => now()->subDays(29)->toDateString(),
                    'to' => now()->toDateString(),
                ],
            ],
        ];
    }
}
