<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MarketingModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $modulePath = base_path('Modules/Marketing');

        $this->loadViewsFrom($modulePath.'/resources/views', 'marketing');

        Route::middleware('web')
            ->group($modulePath.'/routes/web.php');
    }
}
