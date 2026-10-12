<?php

namespace App\Services;

use App\Models\Complain;
use App\Models\Lead;
use App\Models\MarketingPlan;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class MarketingReportService
{
    public function build(array $filters = []): array
    {
        [$from, $to] = $this->resolveDateRange($filters);

        $plans = $this->getPlans($from, $to);
        $complains = $this->getComplains($from, $to);
        $leads = $this->getLeads($from, $to);

        $summary = $this->buildSummary($plans, $complains, $leads, $from, $to);

        return [
            'title' => 'Marketing Reports',
            'subTitle' => 'Dashboard',
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
            'rangeLabel' => $from->format('M d, Y') . ' - ' . $to->format('M d, Y'),
            'summaryCards' => $summary['cards'],
            'sections' => $this->buildSections($plans, $complains, $leads, $from, $to, $summary),
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

    protected function resolveDateRange(array $filters): array
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

    protected function parseDate(?string $value): ?Carbon
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

    protected function getPlans(Carbon $from, Carbon $to): Collection
    {
        if (!Schema::hasTable((new MarketingPlan())->getTable())) {
            return collect();
        }

        return MarketingPlan::query()
            ->with('staff:id,first_name,last_name,full_name')
            ->where(function ($query) use ($from, $to) {
                $query->whereBetween('publish_date', [$from->toDateString(), $to->toDateString()])
                    ->orWhere(function ($nested) use ($from, $to) {
                        $nested->whereNull('publish_date')
                            ->whereBetween('created_at', [$from->copy()->startOfDay(), $to->copy()->endOfDay()]);
                    });
            })
            ->get();
    }

    protected function getComplains(Carbon $from, Carbon $to): Collection
    {
        if (!Schema::hasTable((new Complain())->getTable())) {
            return collect();
        }

        return Complain::query()
            ->with([
                'staff:id,first_name,last_name,full_name',
                'sales:id,first_name,last_name,full_name',
                'solver:id,full_name',
            ])
            ->where(function ($query) use ($from, $to) {
                $query->whereBetween('date', [$from->toDateString(), $to->toDateString()])
                    ->orWhereBetween('created_at', [$from->copy()->startOfDay(), $to->copy()->endOfDay()]);
            })
            ->get();
    }

    protected function getLeads(Carbon $from, Carbon $to): Collection
    {
        $lead = new Lead();

        if (!Schema::hasTable($lead->getTable()) || !Schema::hasColumn($lead->getTable(), 'created_at')) {
            return collect();
        }

        return Lead::query()
            ->whereBetween('created_at', [$from->copy()->startOfDay(), $to->copy()->endOfDay()])
            ->get();
    }

    protected function buildSummary(Collection $plans,Collection $complains,Collection $leads,Carbon $from,Carbon $to): array {
        $publishedPlans = $plans->where('status', 'published')->count();
        $readyPlans = $plans->whereIn('status', ['ready-to-publish', 'published'])->count();
        $solvedComplains = $complains->where('status', 'solved')->count();
        $assignedLeads = $leads->filter(fn ($lead) => !empty($lead->assigned_to))->count();

        $publishReadinessRate = $this->percentage($readyPlans, $plans->count());
        $resolutionRate = $this->percentage($solvedComplains, $complains->count());
        $leadAssignmentRate = $this->percentage($assignedLeads, $leads->count());
        $avgHandlingHours = $this->averageHandlingHours($complains);

        $planRange = ['start_date' => $from->toDateString(), 'end_date' => $to->toDateString()];
        $complainRange = ['start_date' => $from->toDateString(), 'end_date' => $to->toDateString()];

        return [
            'cards' => [
                [
                    'label' => 'Scheduled Plans',
                    'value' => $plans->count(),
                    'meta' => $publishedPlans . ' published',
                    'url' => $this->plansUrl($planRange),
                ],
                [
                    'label' => 'Publish Readiness',
                    'value' => $publishReadinessRate . '%',
                    'meta' => $readyPlans . ' ready or live',
                    'url' => $this->plansUrl($planRange),
                ],
                [
                    'label' => 'Complaints',
                    'value' => $complains->count(),
                    'meta' => $resolutionRate . '% resolved',
                    'url' => $this->complainsUrl($complainRange),
                ],
                [
                    'label' => 'Avg Handling',
                    'value' => $avgHandlingHours,
                    'meta' => 'estimated',
                    'url' => $this->complainsUrl($complainRange + ['status' => 'solved']),
                ],
                [
                    'label' => 'New Leads',
                    'value' => $leads->count(),
                    'meta' => $leadAssignmentRate . '% assigned',
                    'url' => $this->leadsUrl(),
                ],
            ],
            'publish_readiness_rate' => $publishReadinessRate,
            'resolution_rate' => $resolutionRate,
            'lead_assignment_rate' => $leadAssignmentRate,
        ];
    }

    protected function buildSections(Collection $plans,Collection $complains,Collection $leads,Carbon $from,Carbon $to,array $summary): array {
        $planStatus = $this->countBy($plans, 'status', [
            'draft' => 'Draft',
            'under-review' => 'Under Review',
            'ready-to-publish' => 'Ready To Publish',
            'not-approved' => 'Not Approved',
            'published' => 'Published',
        ], fn ($key) => $this->plansUrl([
            'status' => $key,
            'start_date' => $from->toDateString(),
            'end_date' => $to->toDateString(),
        ]));

        $planPlatforms = $this->countBy($plans, 'platform', [
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'tiktok' => 'TikTok',
            'youtube' => 'YouTube',
            'X' => 'X',
            'snapchat' => 'Snapchat',
        ], fn ($key) => $this->plansUrl([
            'platform' => $key,
            'start_date' => $from->toDateString(),
            'end_date' => $to->toDateString(),
        ]));

        $complainPriorities = $this->countBy($complains, 'priority', [
            'high' => 'High',
            'medium' => 'Medium',
            'low' => 'Low',
        ], fn ($key) => $this->complainsUrl([
            'priority' => $key,
            'start_date' => $from->toDateString(),
            'end_date' => $to->toDateString(),
        ]));

        $complainPlatforms = $this->countBy($complains, 'platform', [
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'tiktok' => 'TikTok',
            'youtube' => 'YouTube',
            'X' => 'X',
            'snapchat' => 'Snapchat',
        ], fn ($key) => $this->complainsUrl([
            'platform' => $key,
            'start_date' => $from->toDateString(),
            'end_date' => $to->toDateString(),
        ]));

        $complainStatuses = [
            [
                'label' => 'Solved',
                'value' => $complains->where('status', 'solved')->count(),
                'url' => $this->complainsUrl([
                    'status' => 'solved',
                    'start_date' => $from->toDateString(),
                    'end_date' => $to->toDateString(),
                ]),
            ],
            [
                'label' => 'Open',
                'value' => $complains->where('status', '!=', 'solved')->count(),
                'url' => $this->complainsUrl([
                    'status' => 'not_solved',
                    'start_date' => $from->toDateString(),
                    'end_date' => $to->toDateString(),
                ]),
            ],
        ];

        $leadSources = $this->countBy($leads, 'source', [], fn ($key) => $this->leadsUrl(['source' => $key]));
        $leadAssignment = [
            [
                'label' => 'Assigned',
                'value' => $leads->filter(fn ($lead) => !empty($lead->assigned_to))->count(),
                'url' => $this->leadsUrl(['assign_type' => 'assigned']),
            ],
            [
                'label' => 'Unassigned',
                'value' => $leads->filter(fn ($lead) => empty($lead->assigned_to))->count(),
                'url' => $this->leadsUrl(['assign_type' => 'not_assigned']),
            ],
        ];

        $planTrend = $this->countByDateRange(
            $plans,
            $from,
            $to,
            fn ($plan) => $plan->publish_date ?: optional($plan->created_at)->toDateString(),
            fn ($date) => $this->plansUrl(['start_date' => $date, 'end_date' => $date])
        );

        $complainTrend = $this->countByDateRange(
            $complains,
            $from,
            $to,
            function ($complain) use ($from, $to) {
                if ($complain->date) {
                    $date = Carbon::parse($complain->date);

                    if ($date->betweenIncluded($from, $to)) {
                        return $date->toDateString();
                    }
                }

                return optional($complain->created_at)->toDateString();
            },
            fn ($date) => $this->complainsUrl(['start_date' => $date, 'end_date' => $date])
        );

        $leadTrend = $this->countByDateRange(
            $leads,
            $from,
            $to,
            fn ($lead) => optional($lead->created_at)->toDateString(),
            fn () => $this->leadsUrl()
        );

        $planOwners = $this->topStaff(
            $plans,
            fn ($plan) => $plan->staff,
            5,
            fn ($staffId) => $this->plansUrl([
                'created_by' => $staffId,
                'start_date' => $from->toDateString(),
                'end_date' => $to->toDateString(),
            ])
        );

        $complainOwners = $this->topStaff(
            $complains,
            fn ($complain) => $complain->staff,
            5,
            fn ($staffId) => $this->complainsUrl([
                'creator_id' => $staffId,
                'start_date' => $from->toDateString(),
                'end_date' => $to->toDateString(),
            ])
        );

        $salesOwners = $this->topStaff(
            $complains,
            fn ($complain) => $complain->sales,
            5,
            fn ($staffId) => $this->complainsUrl([
                'staff_id' => $staffId,
                'start_date' => $from->toDateString(),
                'end_date' => $to->toDateString(),
            ])
        );

        $throughput = [
            ['label' => 'Plans', 'value' => $plans->count(), 'url' => $this->plansUrl(['start_date' => $from->toDateString(), 'end_date' => $to->toDateString()])],
            ['label' => 'Complaints', 'value' => $complains->count(), 'url' => $this->complainsUrl(['start_date' => $from->toDateString(), 'end_date' => $to->toDateString()])],
            ['label' => 'Leads', 'value' => $leads->count(), 'url' => $this->leadsUrl()],
        ];

        $health = [
            ['label' => 'Publish Readiness', 'value' => $summary['publish_readiness_rate'], 'url' => $this->plansUrl(['start_date' => $from->toDateString(), 'end_date' => $to->toDateString()])],
            ['label' => 'Resolution Rate', 'value' => $summary['resolution_rate'], 'url' => $this->complainsUrl(['status' => 'solved', 'start_date' => $from->toDateString(), 'end_date' => $to->toDateString()])],
            ['label' => 'Lead Assignment', 'value' => $summary['lead_assignment_rate'], 'url' => $this->leadsUrl()],
        ];

        return [
            'overview' => [
                'title' => 'Overview',
                'left' => [
                    'chart' => $this->makeBarChart('Plan Lifecycle', $planStatus),
                    'list' => $this->makeProgressList($planStatus),
                ],
                'right' => [
                    'chart' => $this->makeLineChart('Complaint Trend', $complainTrend),
                    'list' => $this->makeProgressList($complainPriorities),
                ],
            ],
            'plans' => [
                'title' => 'Plans',
                'left' => [
                    'chart' => $this->makeBarChart('Plans By Platform', $planPlatforms),
                    'list' => $this->makeProgressList($planPlatforms),
                ],
                'right' => [
                    'chart' => $this->makeLineChart('Publishing Timeline', $planTrend),
                    'list' => $this->makeProgressList($planOwners),
                ],
            ],
            'complaints' => [
                'title' => 'Complaints',
                'left' => [
                    'chart' => $this->makeBarChart('Complaints By Platform', $complainPlatforms),
                    'list' => $this->makeProgressList($complainPlatforms),
                ],
                'right' => [
                    'chart' => $this->makeBarChart('Resolution Split', $complainStatuses),
                    'list' => $this->makeProgressList($salesOwners ?: $complainOwners),
                ],
            ],
            'leads' => [
                'title' => 'Leads',
                'left' => [
                    'chart' => $this->makeBarChart('Lead Sources', $leadSources),
                    'list' => $this->makeProgressList($leadSources),
                ],
                'right' => [
                    'chart' => $this->makeLineChart('Lead Creation Trend', $leadTrend),
                    'list' => $this->makeProgressList($leadAssignment),
                ],
            ],
            'performance' => [
                'title' => 'Performance',
                'left' => [
                    'chart' => $this->makeBarChart('Module Throughput', $throughput),
                    'list' => $this->makeProgressList($throughput),
                ],
                'right' => [
                    'chart' => $this->makeBarChart('Service Health %', $health, '%'),
                    'list' => $this->makeProgressList($health, 100),
                ],
            ],
        ];
    }

    protected function countBy(Collection $items,string $field,array $labels = [],?callable $urlResolver = null): array {
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

    protected function countByDateRange(Collection $items,Carbon $from,Carbon $to,callable $dateResolver,?callable $urlResolver = null): array {
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

    protected function topStaff(Collection $items,callable $resolver,int $limit = 5,?callable $urlResolver = null): array {
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

    protected function makeBarChart(string $title, array $items, string $suffix = ''): array
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

    protected function makeLineChart(string $title, array $items): array
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

    protected function makeProgressList(array $items, ?int $max = null): array
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

    protected function averageHandlingHours(Collection $complains): string
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

    protected function percentage(int $value, int $total): int
    {
        if ($total === 0) {
            return 0;
        }

        return (int) round(($value / $total) * 100);
    }

    protected function normalizeLabel(string $value): string
    {
        return ucwords(str_replace(['-', '_'], ' ', $value));
    }

    protected function plansUrl(array $params = []): string
    {
        return route('plans.index', $this->cleanParams($params));
    }

    protected function complainsUrl(array $params = []): string
    {
        return route('complains.index', $this->cleanParams($params));
    }

    protected function leadsUrl(array $params = []): string
    {
        $base = rtrim((string) config('app.CRM_URL'), '/');

        if ($base === '') {
            return route('dashboard');
        }

        $query = http_build_query($this->cleanParams($params));

        return $base . '/leads' . ($query ? ('?' . $query) : '');
    }

    protected function cleanParams(array $params): array
    {
        return collect($params)
            ->reject(fn ($value) => $value === null || $value === '')
            ->all();
    }
}
