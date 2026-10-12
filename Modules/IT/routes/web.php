<?php

use Illuminate\Support\Facades\Route;
use Modules\IT\Products\Http\Controllers\ProductController;
use Modules\IT\Vendors\Http\Controllers\VendorController;
use Modules\IT\TicketConfiguration\Http\Controllers\TicketCategoryController;
use Modules\IT\TicketConfiguration\Http\Controllers\TicketItemController;
use Modules\IT\TicketConfiguration\Http\Controllers\TicketPriorityController;
use Modules\IT\Solutions\Http\Controllers\BrowseSolutionsController;
use Modules\IT\Solutions\Http\Controllers\SolutionController;

Route::prefix('it')->name('it.')->group(function () {
    // Saved tables, purchases, expenses, assets and tickets are pending their controllers.

    // Ticket configuration.
    Route::resource('ticket-items', TicketItemController::class)->parameters(['ticket-items' => 'record'])->whereNumber('record');
    Route::resource('ticket-categories', TicketCategoryController::class)->parameters(['ticket-categories' => 'record'])->whereNumber('record');
    Route::resource('ticket-priorities', TicketPriorityController::class)->parameters(['ticket-priorities' => 'record'])->whereNumber('record');

    // Vendors.
    Route::get('vendors/export', [VendorController::class, 'export'])->name('vendors.export');
    Route::resource('vendors', VendorController::class);

    // Products.
    Route::resource('products', ProductController::class);

    // Solutions. Dashboards are pending implementation.
    Route::resource('it-solutions', SolutionController::class)->parameters(['it-solutions' => 'solution'])->whereNumber('solution');
    Route::get('solutions', [BrowseSolutionsController::class, 'index'])->name('solutions.browse');
    Route::get('solutions/{id}', [BrowseSolutionsController::class, 'show'])->whereNumber('id')->name('solutions.view');

    // Authentication, notifications and Firebase configuration belong to shared modules.
});
