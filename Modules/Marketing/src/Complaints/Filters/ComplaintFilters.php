<?php

namespace Modules\Marketing\Complaints\Filters;

use Illuminate\Database\Eloquent\Builder;

class ComplaintFilters
{
    public function __construct(private readonly array $filters)
    {
    }

    public function apply(Builder $query): Builder
    {
        return $query
            ->when($this->filters['search'] ?? null, $this->search(...))
            ->when($this->filters['platform'] ?? null, fn ($q, $value) => $q->where('platform', $value))
            ->when($this->filters['staff_id'] ?? null, fn ($q, $value) => $q->where('staff_id', $value))
            ->when($this->filters['priority'] ?? null, fn ($q, $value) => $q->where('priority', $value))
            ->when($this->filters['status'] ?? null, fn ($q, $value) => $q->where('status', $value))
            ->when($this->filters['inside_outside'] ?? null, fn ($q, $value) => $q->where('inside_outside', $value))
            ->when($this->filters['department'] ?? null, fn ($q, $value) => $q->where('department', $value))
            ->when($this->filters['case_type'] ?? null, fn ($q, $value) => $q->where('case_type', $value))
            ->when($this->filters['creator_id'] ?? null, fn ($q, $value) => $q->where('created_by', $value));

        $this->applyDates($query);

        return $query;
    }

    private function search(Builder $query, string $value): void
    {
        $query->where(function (Builder $query) use ($value) {
            $query->where('client_name', 'like', "%{$value}%")
                ->orWhere('client_number', 'like', "%{$value}%");
        });
    }

    private function applyDates(Builder $query): void
    {
        $from = $this->filters['date_from']
            ?? $this->filters['from']
            ?? $this->filters['start_date']
            ?? null;

        $to = $this->filters['date_to']
            ?? $this->filters['to']
            ?? $this->filters['end_date']
            ?? null;

        if ($from && $to) {
            $query->whereBetween('date', [$from, $to]);
            return;
        }

        if ($from) {
            $query->whereDate('date', '>=', $from);
        }

        if ($to) {
            $query->whereDate('date', '<=', $to);
        }
    }
}
