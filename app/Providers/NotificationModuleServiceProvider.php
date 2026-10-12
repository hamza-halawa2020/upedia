<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Notifications\Console\SendTestNotificationCommand;

class NotificationModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->commands([SendTestNotificationCommand::class]);
        $modulePath = base_path('Modules/Notifications');

        $this->loadViewsFrom($modulePath.'/resources/views', 'notifications');

        Route::middleware('web')
            ->group($modulePath.'/routes/web.php');
    }
}
