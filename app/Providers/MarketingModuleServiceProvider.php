<?php

namespace App\Providers;

use App\Models\Complain;
use App\Models\MarketingPlan;
use App\Models\QuickLink;
use App\Models\Script;
use App\Observers\ComplainObserver;
use App\Observers\MarketingPlanObserver;
use App\Observers\QuickLinkObserver;
use App\Observers\ScriptObserver;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MarketingModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        MarketingPlan::observe(MarketingPlanObserver::class);
        Script::observe(ScriptObserver::class);
        Complain::observe(ComplainObserver::class);
        QuickLink::observe(QuickLinkObserver::class);

        $modulePath = base_path('Modules/Marketing');

        $this->loadViewsFrom($modulePath.'/resources/views', 'marketing');

        Route::middleware('web')
            ->group($modulePath.'/routes/web.php');
    }
}
