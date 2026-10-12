<?php

use Illuminate\Support\Facades\Route;
use Modules\Notifications\Http\Controllers\NotificationController;

Route::middleware(['sso.token', 'auth'])
    ->prefix('notifications')
    ->as('notifications.')
    ->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/token', [NotificationController::class, 'storeToken'])->name('storeToken');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('markAllRead');
        Route::post('/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('markAsRead');
    });

