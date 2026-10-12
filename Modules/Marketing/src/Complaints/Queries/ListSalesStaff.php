<?php

namespace Modules\Marketing\Complaints\Queries;

use App\Models\Staff;
use Illuminate\Support\Collection;

class ListSalesStaff
{
    public function handle(): Collection
    {
        return Staff::query()
            ->whereHas('jobTitle', fn ($query) => $query->where('slug', 'agent'))
            ->select('id', 'first_name', 'last_name', 'full_name')
            ->orderBy('first_name')
            ->get();
    }
}
