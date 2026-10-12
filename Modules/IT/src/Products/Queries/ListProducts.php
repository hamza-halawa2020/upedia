<?php

namespace Modules\IT\Products\Queries;

use App\Models\ItProduct;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\IT\Products\Filters\ProductFilters;

class ListProducts
{
    public function __construct(private readonly ProductFilters $filters) {}

    public function handle(array $criteria): LengthAwarePaginator
    {
        return $this->filters->apply(ItProduct::query(), $criteria)
            ->latest('id')->paginate(10)->withQueryString();
    }
}
