<?php

namespace Modules\Marketing\Scripts\Filters;

use Illuminate\Database\Eloquent\Builder;

class ScriptFilters
{
    public function apply(Builder $query, array $criteria): Builder
    {
        return $query
            ->when($criteria['category_name'] ?? null, fn ($q, $category) => $q->where('category_name', $category))
            ->when($criteria['search'] ?? null, fn ($q, $search) => $q->where('title', 'like', "%{$search}%"))
            ->when($criteria['visibility'] ?? null, fn ($q, $visibility) => $q->where('visibility', $visibility))
            ->when($criteria['status'] ?? null, fn ($q, $status) => $q->where('status', $status))
            ->when($criteria['department_id'] ?? null, fn ($q, $departmentId) => $q->whereHas(
                'departments',
                fn ($departmentQuery) => $departmentQuery->where('sm_human_departments.id', $departmentId)
            ));
    }
}

