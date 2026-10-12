<?php

namespace Modules\Marketing\Plans\Filters;

use Illuminate\Database\Eloquent\Builder;

class MarketingPlanFilters
{
    public function apply(Builder $query, array $criteria): Builder
    {
        return $this->dateRange($this->basic($query, $criteria), $criteria);
    }

    private function basic(Builder $query, array $criteria): Builder
    {
        return $query
            ->when($criteria['search'] ?? null, fn ($q, $search) => $q->where(function ($nested) use ($search) {
                $nested->where('name', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            }))
            ->when($criteria['platform'] ?? null, fn ($q, $platform) => $q->where('platform', $platform))
            ->when($criteria['status'] ?? null, fn ($q, $status) => $q->where('status', $status))
            ->when($criteria['type'] ?? null, fn ($q, $type) => $q->where('type', $type))
            ->when($criteria['created_by'] ?? null, fn ($q, $staffId) => $q->where('created_by', $staffId))
            ->when($criteria['month'] ?? null, fn ($q, $month) => $q->where('month', $month));
    }

    private function dateRange(Builder $query, array $criteria): Builder
    {
        $from = $criteria['from'] ?? $criteria['start_date'] ?? null;
        $to = $criteria['to'] ?? $criteria['end_date'] ?? null;

        return $query
            ->when($from && $to, fn ($q) => $q->whereBetween('publish_date', [$from, $to]))
            ->when($from && ! $to, fn ($q) => $q->whereDate('publish_date', '>=', $from))
            ->when(! $from && $to, fn ($q) => $q->whereDate('publish_date', '<=', $to));
    }
}

