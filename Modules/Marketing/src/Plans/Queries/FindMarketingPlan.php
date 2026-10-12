<?php

namespace Modules\Marketing\Plans\Queries;

use App\Models\MarketingPlan;

class FindMarketingPlan
{
    public function handle(int $planId): MarketingPlan
    {
        return MarketingPlan::query()
            ->with(['staff:id,first_name,last_name', 'attachments'])
            ->findOrFail($planId);
    }
}

