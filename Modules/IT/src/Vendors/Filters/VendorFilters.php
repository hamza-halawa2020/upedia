<?php

namespace Modules\IT\Vendors\Filters;

use Illuminate\Database\Eloquent\Builder;

class VendorFilters
{
    public function apply(Builder $query, array $criteria): Builder
    {
        $search = $criteria['search'] ?? '';
        if ($search !== '') {
            $query->where(function (Builder $query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%')
                    ->orWhere('location', 'like', '%'.$search.'%');
            });
        }

        return $query;
    }
}
