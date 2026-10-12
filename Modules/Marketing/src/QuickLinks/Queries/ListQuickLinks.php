<?php

namespace Modules\Marketing\QuickLinks\Queries;

use App\Models\QuickLink;
use Illuminate\Support\Collection;

class ListQuickLinks
{
    public function handle(): Collection
    {
        return QuickLink::query()
            ->with('departments:id,name')
            ->orderByDesc('id')
            ->get();
    }
}
