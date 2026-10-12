<?php

namespace Modules\Marketing\Plans\Actions;

use App\Models\MarketingPlan;

class CreateMarketingPlan
{
    public function __construct(private readonly StoreMarketingPlanAttachments $attachments)
    {
    }

    public function handle(array $data, mixed $files = null): MarketingPlan
    {
        $plan = MarketingPlan::create($data);

        $this->attachments->handle($plan, $files);

        return $plan;
    }
}

