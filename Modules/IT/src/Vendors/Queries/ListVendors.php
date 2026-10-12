<?php

namespace Modules\IT\Vendors\Queries;

use App\Models\Vendor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Modules\IT\Vendors\Filters\VendorFilters;

class ListVendors
{
    public function __construct(private readonly VendorFilters $filters) {}

    public function query(array $criteria): Builder
    {
        return $this->filters->apply(Vendor::query(), $criteria)->latest('id');
    }

    public function handle(array $criteria): LengthAwarePaginator
    {
        return $this->query($criteria)->paginate($criteria['per_page'] ?? 10)->withQueryString();
    }
}
