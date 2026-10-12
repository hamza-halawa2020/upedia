<?php

namespace Modules\Marketing\Plans\Actions;

use App\Models\MarketingPlan;
use Illuminate\Support\Facades\DB;

class UpdateMarketingPlan
{
    public function __construct(
        private readonly StoreMarketingPlanAttachments $storeAttachments,
        private readonly DeleteMarketingPlanAttachments $deleteAttachments,
    ) {
    }

    public function handle(int $planId, array $data, mixed $files = null): MarketingPlan
    {
        return DB::transaction(function () use ($planId, $data, $files) {
            $plan = MarketingPlan::with('attachments')->findOrFail($planId);
            $plan->update($data);

            if ($files !== null) {
                $this->deleteAttachments->handle($plan);
                $this->storeAttachments->handle($plan, $files);
            }

            return $plan;
        });
    }
}

