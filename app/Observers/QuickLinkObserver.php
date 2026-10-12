<?php

namespace App\Observers;

use App\Models\QuickLink;
use App\Services\Notifications\MarketingNotificationService;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class QuickLinkObserver implements ShouldHandleEventsAfterCommit
{
    public function created(QuickLink $quickLink): void
    {
        app(MarketingNotificationService::class)->quickLinkChanged($quickLink, 'created');
    }

    public function updated(QuickLink $quickLink): void
    {
        app(MarketingNotificationService::class)->quickLinkChanged($quickLink, 'updated');
    }

    public function deleted(QuickLink $quickLink): void
    {
        app(MarketingNotificationService::class)->quickLinkChanged($quickLink, 'deleted');
    }
}
