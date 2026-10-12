<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\IT\Tickets\Console\RebuildTicketDeadlinesCommand;
use Modules\IT\Tickets\Console\SendTicketRemindersCommand;

class ITModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(base_path('Modules/IT/config/it.php'), 'it');
    }

    public function boot(): void
    {
        $this->commands([SendTicketRemindersCommand::class,
            RebuildTicketDeadlinesCommand::class]);
        $path = base_path('Modules/IT');
        $this->loadViewsFrom($path.'/resources/views', 'it');
        Route::middleware(['web', 'sso.token', 'auth'])->group($path.'/routes/web.php');
    }
}
