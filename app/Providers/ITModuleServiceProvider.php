<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ITModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $path = base_path('Modules/IT');
        $this->loadViewsFrom($path.'/resources/views', 'it');
        Route::middleware(['web', 'sso.token', 'auth'])->group($path.'/routes/web.php');
    }
}
