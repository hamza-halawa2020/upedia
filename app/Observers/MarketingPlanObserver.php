<?php

namespace App\Observers;

use App\Models\MarketingPlan;
use App\Services\Notifications\MarketingNotificationService;

class MarketingPlanObserver
{
    public function created(MarketingPlan $marketingPlan): void
    {
        app(MarketingNotificationService::class)->planChanged($marketingPlan, 'created');
    }

    public function updated(MarketingPlan $marketingPlan): void
    {
        app(MarketingNotificationService::class)->planChanged($marketingPlan, 'updated');
    }

    public function deleted(MarketingPlan $marketingPlan): void
    {
        app(MarketingNotificationService::class)->planChanged($marketingPlan, 'deleted');
    }
}