<?php

namespace Modules\Marketing\Reports\Builders;

use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Support\Collection;


class ReportSections
{
    public function __construct(
        private readonly ReportCharts $charts,
        private readonly ReportLinks $links,
        private readonly ReportBreakdowns $breakdowns,
        private readonly ReportTrends $trends
    ) {}

    public function build(Collection $plans, Collection $complains, Collection $leads, Carbon $from, Carbon $to, array $summary): array
    {
        $breakdowns = $this->breakdowns->build($plans, $complains, $leads, $from, $to, $summary);
        $trends = $this->trends->build($plans, $complains, $leads, $from, $to, $summary);

        $throughput = [
            ['label' => 'Plans', 'value' => $plans->count(), 'url' => $this->links->plansUrl(['start_date' => $from->toDateString(), 'end_date' => $to->toDateString()])],
            ['label' => 'Complaints', 'value' => $complains->count(), 'url' => $this->links->complainsUrl(['start_date' => $from->toDateString(), 'end_date' => $to->toDateString()])],
            ['label' => 'Leads', 'value' => $leads->count(), 'url' => $this->links->leadsUrl()],
        ];

        $health = [
            ['label' => 'Publish Readiness', 'value' => $summary['publish_readiness_rate'], 'url' => $this->links->plansUrl(['start_date' => $from->toDateString(), 'end_date' => $to->toDateString()])],
            ['label' => 'Resolution Rate', 'value' => $summary['resolution_rate'], 'url' => $this->links->complainsUrl(['status' => 'solved', 'start_date' => $from->toDateString(), 'end_date' => $to->toDateString()])],
            ['label' => 'Lead Assignment', 'value' => $summary['lead_assignment_rate'], 'url' => $this->links->leadsUrl()],
        ];

        return [
            'overview' => [
                'title' => 'Overview',
                'left' => [
                    'chart' => $this->charts->makeBarChart('Plan Lifecycle', $breakdowns['planStatus']),
                    'list' => $this->charts->makeProgressList($breakdowns['planStatus']),
                ],
                'right' => [
                    'chart' => $this->charts->makeLineChart('Complaint Trend', $trends['complainTrend']),
                    'list' => $this->charts->makeProgressList($breakdowns['complainPriorities']),
                ],
            ],
            'plans' => [
                'title' => 'Plans',
                'left' => [
                    'chart' => $this->charts->makeBarChart('Plans By Platform', $breakdowns['planPlatforms']),
                    'list' => $this->charts->makeProgressList($breakdowns['planPlatforms']),
                ],
                'right' => [
                    'chart' => $this->charts->makeLineChart('Publishing Timeline', $trends['planTrend']),
                    'list' => $this->charts->makeProgressList($trends['planOwners']),
                ],
            ],
            'complaints' => [
                'title' => 'Complaints',
                'left' => [
                    'chart' => $this->charts->makeBarChart('Complaints By Platform', $breakdowns['complainPlatforms']),
                    'list' => $this->charts->makeProgressList($breakdowns['complainPlatforms']),
                ],
                'right' => [
                    'chart' => $this->charts->makeBarChart('Resolution Split', $breakdowns['complainStatuses']),
                    'list' => $this->charts->makeProgressList($trends['salesOwners'] ?: $trends['complainOwners']),
                ],
            ],
            'leads' => [
                'title' => 'Leads',
                'left' => [
                    'chart' => $this->charts->makeBarChart('Lead Sources', $breakdowns['leadSources']),
                    'list' => $this->charts->makeProgressList($breakdowns['leadSources']),
                ],
                'right' => [
                    'chart' => $this->charts->makeLineChart('Lead Creation Trend', $trends['leadTrend']),
                    'list' => $this->charts->makeProgressList($breakdowns['leadAssignment']),
                ],
            ],
            'performance' => [
                'title' => 'Performance',
                'left' => [
                    'chart' => $this->charts->makeBarChart('Module Throughput', $throughput),
                    'list' => $this->charts->makeProgressList($throughput),
                ],
                'right' => [
                    'chart' => $this->charts->makeBarChart('Service Health %', $health, '%'),
                    'list' => $this->charts->makeProgressList($health, 100),
                ],
            ],
        ];
    }
}
