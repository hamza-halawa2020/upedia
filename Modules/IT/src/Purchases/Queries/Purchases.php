<?php

namespace Modules\IT\Purchases\Queries;

use App\Models\CostCenter;
use App\Models\Purchase;
use App\Models\Staff;
use App\Models\Vendor;
use Modules\IT\Purchases\Filters\PurchaseFilters;

class Purchases
{
    public function __construct(private readonly PurchaseFilters $filters) {}

    public function query(array $criteria = [])
    {
        return $this->filters->apply(Purchase::where('invoice_type', 'purchase')
            ->with(['requestedStaffs', 'costCenter']), $criteria)->latest('id');
    }

    public function list(array $criteria)
    {
        return $this->query($criteria)->paginate($criteria['per_page'] ?? 10)->withQueryString();
    }

    public function find(int $id): Purchase
    {
        return $this->query()->with(['details', 'vendors', 'attachments'])->findOrFail($id);
    }

    public function options(): array
    {
        return ['staffs' => Staff::orderBy('first_name')->get(['id', 'first_name', 'last_name']),
            'vendors' => Vendor::orderBy('name')->get(['id', 'name']),
            'costCenters' => CostCenter::where('status', 'active')->get(['id', 'title'])];
    }
}
