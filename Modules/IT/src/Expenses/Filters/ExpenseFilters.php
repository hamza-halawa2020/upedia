<?php

namespace Modules\IT\Expenses\Filters;

use Illuminate\Database\Eloquent\Builder;

class ExpenseFilters
{
    public function apply(Builder $query, array $criteria): Builder
    {
        if ($search = $criteria['search'] ?? null) {
            $query->where(function ($query) use ($search) {
                foreach (['amount', 'vendors', 'item_name', 'payment_method', 'recurring'] as $field) {
                    $query->orWhere($field, 'like', '%'.$search.'%');
                }
            });
        }
        foreach (['status', 'recurring'] as $field) {
            if (! empty($criteria[$field])) {
                $query->where($field, $criteria[$field]);
            }
        }
        if (! empty($criteria['start_date'])) {
            $query->whereDate('payment_date', '>=', $criteria['start_date']);
        }
        if (! empty($criteria['end_date'])) {
            $query->whereDate('payment_date', '<=', $criteria['end_date']);
        }

        return $query;
    }
}
