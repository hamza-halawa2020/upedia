<?php

namespace App\Observers;

use App\Models\Complain;
use App\Services\Notifications\MarketingNotificationService;

class ComplainObserver
{
    public function created(Complain $complain): void
    {
        app(MarketingNotificationService::class)->complainChanged($complain, 'created');
    }

    public function updated(Complain $complain): void
    {
        app(MarketingNotificationService::class)->complainChanged($complain, 'updated');
    }

    public function deleted(Complain $complain): void
    {
        app(MarketingNotificationService::class)->complainChanged($complain, 'deleted');
    }
}