<?php

namespace Modules\IT\Assets\Filters;

class AssetFilters
{
    public function apply($query, array $criteria)
    {
        if ($search = $criteria['search'] ?? null) {
            $query->where(function ($query) use ($search) {
                foreach (['name', 'model', 'serial_number'] as $field) {
                    $query->orWhere($field, 'like', '%'.$search.'%');
                }
                foreach (['product', 'vendor', 'department'] as $relation) {
                    $query->orWhereHas($relation, fn ($q) => $q->where('name', 'like', '%'.$search.'%'));
                }
            });
        }
        if (! empty($criteria['status'])) {
            $query->where('is_currently_in_use', $criteria['status']);
        }
        if (! empty($criteria['start_date'])) {
            $query->whereDate('acquisition_date', '>=', $criteria['start_date']);
        }
        if (! empty($criteria['end_date'])) {
            $query->whereDate('acquisition_date', '<=', $criteria['end_date']);
        }

        return $query;
    }
}
