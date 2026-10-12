<?php

namespace App\Observers;

use App\Models\Script;
use App\Services\Notifications\MarketingNotificationService;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class ScriptObserver implements ShouldHandleEventsAfterCommit
{
    public function created(Script $script): void
    {
        app(MarketingNotificationService::class)->scriptChanged($script, 'created');
    }

    public function updated(Script $script): void
    {
        app(MarketingNotificationService::class)->scriptChanged($script, 'updated');
    }

    public function deleted(Script $script): void
    {
        app(MarketingNotificationService::class)->scriptChanged($script, 'deleted');
    }
}
