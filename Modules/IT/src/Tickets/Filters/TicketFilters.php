<?php

namespace Modules\IT\Tickets\Filters;

class TicketFilters
{
    public function apply($query, array $data)
    {
        if ($search = $data['search'] ?? null) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%');
                foreach (['category', 'subcategory', 'item'] as $relation) {
                    $q->orWhereHas($relation, fn ($nested) => $nested->where('name', 'like', '%'.$search.'%'));
                }
                foreach (['requester', 'assignedTo'] as $relation) {
                    $q->orWhereHas($relation, fn ($nested) => $nested->where('first_name', 'like', '%'.$search.'%')->orWhere('last_name', 'like', '%'.$search.'%'));
                }
            });
        }
        foreach (['status', 'assigned_to', 'ticket_priority_id', 'requester_id'] as $field) {
            if (! empty($data[$field])) {
                $query->where($field, $data[$field]);
            }
        }
        if (! empty($data['start_date'])) {
            $query->where('created_at', '>=', $data['start_date'].' 00:00:00');
        }
        if (! empty($data['end_date'])) {
            $query->where('created_at', '<=', $data['end_date'].' 23:59:59');
        }

        return $query;
    }
}
