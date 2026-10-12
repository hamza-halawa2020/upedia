<?php

namespace Modules\IT\Assets\Queries;

use App\Models\Asset;
use App\Models\ItProduct;
use App\Models\User;
use App\Models\Vendor;
use App\Queries\ListDepartments;
use Modules\IT\Assets\Filters\AssetFilters;

class Assets
{
    public function __construct(private readonly AssetFilters $filters) {}

    public function query(array $criteria = [])
    {
        return $this->filters->apply(Asset::with(['product:id,name', 'vendor:id,name', 'department:id,name',
            'user:id,full_name', 'user.staff.department:id,name'])
            ->withSum(['accessories as accessories_sum_cost' => fn ($q) => $q->where('enabled', true)], 'cost'), $criteria)->latest('id');
    }

    public function list(array $criteria)
    {
        return $this->query($criteria)->paginate($criteria['per_page'] ?? 15)->withQueryString();
    }

    public function find(int $id): Asset
    {
        return $this->query()->with('accessories')->findOrFail($id);
    }

    public function options(): array
    {
        return ['products' => ItProduct::orderBy('name')->get(['id', 'name']),
            'vendors' => Vendor::orderBy('name')->get(['id', 'name']),
            'departments' => app(ListDepartments::class)->handle(),
            'users' => User::orderBy('full_name')->get(['id', 'full_name'])];
    }
}
