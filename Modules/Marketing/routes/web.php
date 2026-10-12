<?php

use Illuminate\Support\Facades\Route;
use Modules\Marketing\Complaints\Http\Controllers\ComplaintController;
use Modules\Marketing\Plans\Http\Controllers\MarketingPlanController;
use Modules\Marketing\QuickLinks\Http\Controllers\QuickLinkController;
use Modules\Marketing\Scripts\Http\Controllers\ScriptController;

Route::middleware(['sso.token', 'auth'])->prefix('marketing')->group(function () {
    Route::view('/', 'marketing::dashboard.dashboard')->name('marketing.dashboard');
    Route::get('/get-months', [MarketingPlanController::class, 'months'])->name('getMonths');
    Route::get('/calendar', [MarketingPlanController::class, 'calendar'])->name('calendar');
    Route::get('/plans/calendar/events', [MarketingPlanController::class, 'calendarEvents'])->name('plans.calendar.events');
    Route::get('/plans/export', [MarketingPlanController::class, 'export'])->name('plans.export');
    Route::resource('/plans', MarketingPlanController::class);
    Route::get('/scripts/export', [ScriptController::class, 'export'])->name('script.export');
    Route::resource('/scripts', ScriptController::class);
    Route::get('/leads/check', [ComplaintController::class, 'checkLeads'])->name('leads.check');
    Route::resource('/complains', ComplaintController::class);
    Route::get('/quick-links', [QuickLinkController::class, 'index'])->name('quick_links.index');
    Route::post('/quick-links', [QuickLinkController::class, 'store'])->name('quick_links.store');
    Route::put('/quick-links/{quickLink}', [QuickLinkController::class, 'update'])->name('quick_links.update');
    Route::delete('/quick-links/{quickLink}', [QuickLinkController::class, 'destroy'])->name('quick_links.destroy');
});
