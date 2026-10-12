<?php

namespace Modules\Marketing\Plans\Actions;

use App\Models\MarketingPlan;
use App\Actions\Attachments\DeleteAttachments;

class DeleteMarketingPlanAttachments
{
    public function __construct(private readonly DeleteAttachments $attachments) {}
    public function handle(MarketingPlan $plan): void
    {
        $this->attachments->handle($plan);
    }
}
