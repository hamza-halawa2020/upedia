<?php

namespace Modules\Marketing\Reports\Builders;

use Carbon\Carbon;
use Illuminate\Support\Collection;


class ReportSummary
{
    public function __construct(
        private readonly ReportMetrics $metrics,
        private readonly ReportLinks $links
    ) {}

    public function buildSummary(Collection $plans,Collection $complains,Collection $leads,Carbon $from,Carbon $to): array {
        $publishedPlans = $plans->where('status', 'published')->count();
        $readyPlans = $plans->whereIn('status', ['ready-to-publish', 'published'])->count();
        $solvedComplains = $complains->where('status', 'solved')->count();
        $assignedLeads = $leads->filter(fn ($lead) => !empty($lead->assigned_to))->count();

        $publishReadinessRate = $this->metrics->percentage($readyPlans, $plans->count());
        $resolutionRate = $this->metrics->percentage($solvedComplains, $complains->count());
        $leadAssignmentRate = $this->metrics->percentage($assignedLeads, $leads->count());
        $avgHandlingHours = $this->metrics->averageHandlingHours($complains);

        $planRange = ['start_date' => $from->toDateString(), 'end_date' => $to->toDateString()];
        $complainRange = ['start_date' => $from->toDateString(), 'end_date' => $to->toDateString()];

        return [
            'cards' => [
                [
                    'label' => 'Scheduled Plans',
                    'value' => $plans->count(),
                    'meta' => $publishedPlans . ' published',
                    'url' => $this->links->plansUrl($planRange),
                ],
                [
                    'label' => 'Publish Readiness',
                    'value' => $publishReadinessRate . '%',
                    'meta' => $readyPlans . ' ready or live',
                    'url' => $this->links->plansUrl($planRange),
                ],
                [
                    'label' => 'Complaints',
                    'value' => $complains->count(),
                    'meta' => $resolutionRate . '% resolved',
                    'url' => $this->links->complainsUrl($complainRange),
                ],
                [
                    'label' => 'Avg Handling',
                    'value' => $avgHandlingHours,
                    'meta' => 'estimated',
                    'url' => $this->links->complainsUrl($complainRange + ['status' => 'solved']),
                ],
                [
                    'label' => 'New Leads',
                    'value' => $leads->count(),
                    'meta' => $leadAssignmentRate . '% assigned',
                    'url' => $this->links->leadsUrl(),
                ],
            ],
            'publish_readiness_rate' => $publishReadinessRate,
            'resolution_rate' => $resolutionRate,
            'lead_assignment_rate' => $leadAssignmentRate,
        ];
    }
}
