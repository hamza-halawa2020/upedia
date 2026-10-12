<?php

use Illuminate\Support\Facades\Route;
use Modules\Notifications\Http\Controllers\FirebaseNotificationConfigController;
use Modules\Notifications\Http\Controllers\NotificationController;

Route::middleware(['sso.token', 'auth'])->group(function () {
    Route::get('/firebase-configs', [FirebaseNotificationConfigController::class, 'index'])->name('firebase-configs.index');
    Route::post('/firebase-configs', [FirebaseNotificationConfigController::class, 'store'])->name('firebase-configs.store');
});

Route::middleware(['sso.token', 'auth'])
    ->prefix('notifications')
    ->as('notifications.')
    ->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/token', [NotificationController::class, 'storeToken'])->name('storeToken');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('markAllRead');
        Route::post('/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('markAsRead');
    });
