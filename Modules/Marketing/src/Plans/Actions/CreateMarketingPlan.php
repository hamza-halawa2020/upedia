<?php

namespace Modules\Marketing\Plans\Actions;

use App\Models\MarketingPlan;
use Illuminate\Support\Facades\DB;

class CreateMarketingPlan
{
    public function __construct(private readonly StoreMarketingPlanAttachments $attachments)
    {
    }

    public function handle(array $data, mixed $files = null): MarketingPlan
    {
        return DB::transaction(function () use ($data, $files) {
            $plan = MarketingPlan::create($data);
            $this->attachments->handle($plan, $files);

            return $plan;
        });
    }
}

