<?php

namespace Modules\Marketing\Plans\Filters;

use Illuminate\Database\Eloquent\Builder;

class CalendarFilters
{
    public function apply(Builder $query, array $criteria): Builder
    {
        return $query
            ->when($criteria['statuses'] ?? null, fn (Builder $q, string $values) => $q->whereIn('status', explode(',', $values)))
            ->when($criteria['platforms'] ?? null, fn (Builder $q, string $values) => $q->whereIn('platform', explode(',', $values)));
    }
}
