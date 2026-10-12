<?php

namespace Modules\IT\TicketConfiguration\Queries;

use App\Models\TicketCategory;
use App\Models\TicketPriority;
use Illuminate\Database\Eloquent\Model;
use Modules\IT\TicketConfiguration\Catalog;
use Modules\IT\TicketConfiguration\Filters\CatalogFilters;

class CatalogRecords
{
    public function __construct(private readonly CatalogFilters $filters) {}

    public function list(Catalog $catalog, array $criteria)
    {
        $query = $catalog->model()::with($catalog->relationships());

        return $this->filters->apply($query, $catalog, $criteria)
            ->latest('id')->paginate($criteria['per_page'] ?? 10)->withQueryString();
    }

    public function find(Catalog $catalog, int $id): Model
    {
        return $catalog->model()::with($catalog->relationships())->findOrFail($id);
    }

    public function options(Catalog $catalog): array
    {
        if ($catalog === Catalog::Priorities) {
            return [];
        }

        return [
            'categories' => TicketCategory::with('parent')->orderBy('name')->get(),
            'priorities' => $catalog === Catalog::Categories ? TicketPriority::orderBy('name')->get() : collect(),
        ];
    }
}
