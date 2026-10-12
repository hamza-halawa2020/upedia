<?php

namespace Modules\Marketing\Plans\Actions;

use App\Models\MarketingPlan;

class DeleteMarketingPlanAttachments
{
    public function handle(MarketingPlan $plan): void
    {
        foreach ($plan->attachments as $attachment) {
            $filePath = public_path($attachment->file_path);

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $attachment->delete();
        }
    }
}

