<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class NotificationModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $modulePath = base_path('Modules/Notifications');

        $this->loadViewsFrom($modulePath.'/resources/views', 'notifications');

        Route::middleware('web')
            ->group($modulePath.'/routes/web.php');
    }
}
