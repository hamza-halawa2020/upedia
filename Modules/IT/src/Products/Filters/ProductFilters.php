<?php

namespace Modules\IT\Products\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductFilters
{
    public function apply(Builder $query, array $criteria): Builder
    {
        return $query->when($criteria['search'] ?? null, function (Builder $query, string $search) {
            $query->where('name', 'like', '%'.$search.'%');
        });
    }
}
