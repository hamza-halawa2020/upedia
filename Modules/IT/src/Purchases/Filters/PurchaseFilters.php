<?php

namespace Modules\IT\Purchases\Filters;

use Illuminate\Database\Eloquent\Builder;

class PurchaseFilters
{
    public function apply(Builder $query, array $data): Builder
    {
        if (! empty($data['purchase_number'])) {
            $query->where('purchase_number', 'like', '%'.$data['purchase_number'].'%');
        }
        foreach (['status', 'recurring'] as $field) {
            if (isset($data[$field]) && $data[$field] !== '') {
                $query->where($field, $data[$field]);
            }
        }
        if (! empty($data['staff_id'])) {
            $query->whereHas('requestedStaffs', fn ($q) => $q->where('sm_staffs.id', $data['staff_id']));
        }
        if (! empty($data['from_date'])) {
            $query->whereDate('required_by', '>=', $data['from_date']);
        }
        if (! empty($data['to_date'])) {
            $query->whereDate('required_by', '<=', $data['to_date']);
        }

        return $query;
    }
}
