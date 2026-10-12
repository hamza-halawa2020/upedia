<?php

namespace Modules\Marketing\Plans\Actions;

use App\Models\MarketingPlan;
use App\Actions\Attachments\StoreAttachments;

class StoreMarketingPlanAttachments
{
    public function __construct(private readonly StoreAttachments $attachments) {}

    public function handle(MarketingPlan $plan, mixed $files): void
    {
        $this->attachments->handle($plan, $files ?: [], 'marketing-plans');
    }
}
