<?php

namespace Modules\Marketing\Reports\Builders;

use Carbon\Carbon;
use Illuminate\Support\Collection;


class ReportBreakdowns
{
    public function __construct(
        private readonly ReportMetrics $metrics,
        private readonly ReportLinks $links
    ) {}

    public function build(Collection $plans, Collection $complains, Collection $leads, Carbon $from, Carbon $to, array $summary): array
    {
        $planStatus = $this->metrics->countBy($plans, 'status', [
            'draft' => 'Draft',
            'under-review' => 'Under Review',
            'ready-to-publish' => 'Ready To Publish',
            'not-approved' => 'Not Approved',
            'published' => 'Published',
        ], fn ($key) => $this->links->plansUrl([
            'status' => $key,
            'start_date' => $from->toDateString(),
            'end_date' => $to->toDateString(),
        ]));

        $planPlatforms = $this->metrics->countBy($plans, 'platform', [
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'tiktok' => 'TikTok',
            'youtube' => 'YouTube',
            'X' => 'X',
            'snapchat' => 'Snapchat',
        ], fn ($key) => $this->links->plansUrl([
            'platform' => $key,
            'start_date' => $from->toDateString(),
            'end_date' => $to->toDateString(),
        ]));

        $complainPriorities = $this->metrics->countBy($complains, 'priority', [
            'high' => 'High',
            'medium' => 'Medium',
            'low' => 'Low',
        ], fn ($key) => $this->links->complainsUrl([
            'priority' => $key,
            'start_date' => $from->toDateString(),
            'end_date' => $to->toDateString(),
        ]));

        $complainPlatforms = $this->metrics->countBy($complains, 'platform', [
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'tiktok' => 'TikTok',
            'youtube' => 'YouTube',
            'X' => 'X',
            'snapchat' => 'Snapchat',
        ], fn ($key) => $this->links->complainsUrl([
            'platform' => $key,
            'start_date' => $from->toDateString(),
            'end_date' => $to->toDateString(),
        ]));

        $complainStatuses = [
            [
                'label' => 'Solved',
                'value' => $complains->where('status', 'solved')->count(),
                'url' => $this->links->complainsUrl([
                    'status' => 'solved',
                    'start_date' => $from->toDateString(),
                    'end_date' => $to->toDateString(),
                ]),
            ],
            [
                'label' => 'Open',
                'value' => $complains->where('status', '!=', 'solved')->count(),
                'url' => $this->links->complainsUrl([
                    'status' => 'not_solved',
                    'start_date' => $from->toDateString(),
                    'end_date' => $to->toDateString(),
                ]),
            ],
        ];

        $leadSources = $this->metrics->countBy($leads, 'source', [], fn ($key) => $this->links->leadsUrl(['source' => $key]));
        $leadAssignment = [
            [
                'label' => 'Assigned',
                'value' => $leads->filter(fn ($lead) => !empty($lead->assigned_to))->count(),
                'url' => $this->links->leadsUrl(['assign_type' => 'assigned']),
            ],
            [
                'label' => 'Unassigned',
                'value' => $leads->filter(fn ($lead) => empty($lead->assigned_to))->count(),
                'url' => $this->links->leadsUrl(['assign_type' => 'not_assigned']),
            ],
        ];

        return compact('planStatus', 'planPlatforms', 'complainPriorities', 'complainPlatforms', 'complainStatuses', 'leadSources', 'leadAssignment');
    }
}
