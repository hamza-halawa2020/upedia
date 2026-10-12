<?php

namespace Modules\Marketing\Plans\Actions;

use App\Models\MarketingPlan;
use Illuminate\Support\Facades\DB;

class DeleteMarketingPlan
{
    public function __construct(private readonly DeleteMarketingPlanAttachments $deleteAttachments)
    {
    }

    public function handle(int $planId): void
    {
        DB::transaction(function () use ($planId): void {
            $plan = MarketingPlan::with('attachments')->findOrFail($planId);

            $this->deleteAttachments->handle($plan);

            $plan->delete();
        });
    }
}

