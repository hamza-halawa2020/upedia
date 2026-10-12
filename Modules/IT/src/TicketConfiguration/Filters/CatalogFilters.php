<?php

namespace Modules\IT\TicketConfiguration\Filters;

use Illuminate\Database\Eloquent\Builder;
use Modules\IT\TicketConfiguration\Catalog;

class CatalogFilters
{
    public function apply(Builder $query, Catalog $catalog, array $criteria): Builder
    {
        if ($search = $criteria['search'] ?? null) {
            $query->where('name', 'like', '%'.$search.'%');
        }
        if ($catalog === Catalog::Categories && isset($criteria['is_main'])) {
            $criteria['is_main'] ? $query->whereNull('parent_id') : $query->whereNotNull('parent_id');
        }
        if ($catalog === Catalog::Categories && !empty($criteria['parent_id'])) {
            $query->where('parent_id', $criteria['parent_id']);
        }
        if ($catalog === Catalog::Items && !empty($criteria['subcategory_id'])) {
            $query->where('ticket_subcategory_id', $criteria['subcategory_id']);
        }

        return $query;
    }
}
