<?php

namespace Modules\Marketing\Plans\Queries;

use App\Models\MarketingPlan;
use Illuminate\Support\Collection;

class ListPublishedMonths
{
    public function handle(): Collection
    {
        return MarketingPlan::query()
            ->where('status', 'published')
            ->select('month')
            ->distinct()
            ->orderBy('month')
            ->pluck('month');
    }
}

