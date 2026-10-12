<?php

namespace Modules\Marketing\Plans\Queries;

use App\Models\MarketingPlan;
use Illuminate\Support\Collection;
use Modules\Marketing\Plans\Filters\CalendarFilters;

class ListCalendarEvents
{
    public function __construct(private readonly CalendarFilters $filters) {}

    public function handle(array $criteria): Collection
    {
        return $this->filters->apply(MarketingPlan::query(), $criteria)
            ->with(['staff:id,first_name,last_name'])
            ->get()
            ->map(fn (MarketingPlan $plan) => $this->event($plan));
    }

    private function event(MarketingPlan $plan): array
    {
        return [
            'id' => $plan->id,
            'title' => $plan->name,
            'start' => ($plan->publish_date ?? $plan->published_date).'T'.($plan->publish_time ?? '00:00:00'),
            'color' => $this->color($plan->status),
            'extendedProps' => [
                'platform' => $plan->platform ?? '',
                'subject' => $plan->subject ?? '',
                'status' => $plan->status,
                'type' => $plan->type,
                'month' => $plan->month ?? '',
                'created_by' => trim(($plan->staff?->first_name ?? '').' '.($plan->staff?->last_name ?? '')),
            ],
        ];
    }

    private function color(?string $status): string
    {
        return match ($status) {
            'approved' => '#28a745',
            'pending-review' => '#ffc107',
            default => '#007bff',
        };
    }
}
