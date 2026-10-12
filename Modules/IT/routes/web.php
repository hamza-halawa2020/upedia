<?php

use Illuminate\Support\Facades\Route;
use Modules\IT\Assets\Http\Controllers\AssetController;
use Modules\IT\Dashboard\Http\Controllers\DashboardController;
use Modules\IT\Expenses\Http\Controllers\ExpensesController;
use Modules\IT\Products\Http\Controllers\ProductController;
use Modules\IT\Purchases\Http\Controllers\PurchaseController;
use Modules\IT\Reports\Http\Controllers\ReportController;
use Modules\IT\SavedTables\Http\Controllers\SavedTableController;
use Modules\IT\Solutions\Http\Controllers\BrowseSolutionsController;
use Modules\IT\Solutions\Http\Controllers\SolutionController;
use Modules\IT\TicketConfiguration\Http\Controllers\TicketCategoryController;
use Modules\IT\TicketConfiguration\Http\Controllers\TicketItemController;
use Modules\IT\TicketConfiguration\Http\Controllers\TicketPriorityController;
use Modules\IT\Tickets\Http\Controllers\TicketController;
use Modules\IT\Vendors\Http\Controllers\VendorController;

Route::prefix('it')->name('it.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('statistics', [DashboardController::class, 'requestsDashboard'])->name('dashboard');
    Route::get('asset-dashboard', [DashboardController::class, 'assetDashboard'])->name('assetDashboard');
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    // Saved and filtered tables.
    Route::get('filtered-tables', [SavedTableController::class, 'index'])->name('filtered_tables.index');
    Route::get('filtered-tables/{filteredTable}/restore', [SavedTableController::class, 'restore'])->whereNumber('filteredTable')->name('filtered_tables.restore');
    Route::delete('filtered-tables/{filteredTable}', [SavedTableController::class, 'destroy'])->whereNumber('filteredTable')->name('filtered_tables.destroy');
    Route::get('filtered-tables/{filteredTable}/view', [SavedTableController::class, 'view'])->whereNumber('filteredTable')->name('filtered_tables.view');
    Route::get('filtered-tables/{filteredTable}/download', [SavedTableController::class, 'download'])->whereNumber('filteredTable')->name('filtered_tables.download');

    // Purchases.
    Route::post('updateStatus/purchase', [PurchaseController::class, 'updateStatus'])->name('purchase.updateStatus');
    Route::get('purchase/save-filtered-table', [PurchaseController::class, 'saveFilteredTable'])->name('purchase.saveFilteredTable');
    Route::get('purchase/export', [PurchaseController::class, 'export'])->name('purchase.export');
    Route::resource('purchase', PurchaseController::class)->whereNumber('purchase');

    // Expenses.
    Route::post('updateStatus', [ExpensesController::class, 'updateStatus'])->name('expenses.updateStatus');
    Route::get('expenses/save-filtered-table', [ExpensesController::class, 'saveFilteredTable'])->name('expenses.saveFilteredTable');
    Route::get('expenses/export', [ExpensesController::class, 'export'])->name('expenses.export');
    Route::resource('expenses', ExpensesController::class)->whereNumber('expense');

    // Assets.
    Route::get('asset/save-filtered-table', [AssetController::class, 'saveFilteredTable'])->name('asset.saveFilteredTable');
    Route::get('asset/export', [AssetController::class, 'export'])->name('asset.export');
    Route::resource('asset', AssetController::class)->whereNumber('asset');

    // Tickets.
    Route::get('tickets/save-filtered-table', [TicketController::class, 'saveFilteredTable'])->name('tickets.saveFilteredTable');
    Route::get('tickets/export', [TicketController::class, 'export'])->name('tickets.export');
    Route::get('tickets/staff-by-department/{departmentId}', [TicketController::class, 'getStaffByDepartment'])->whereNumber('departmentId')->name('tickets.staffByDepartment');
    Route::get('tickets/staff-search', [TicketController::class, 'searchStaff'])->name('tickets.staffSearch');
    Route::get('tickets/staff-details/{staffId}', [TicketController::class, 'getStaffDetails'])->whereNumber('staffId')->name('tickets.staffDetails');
    Route::resource('tickets', TicketController::class)->whereNumber('ticket');

    // Ticket configuration.
    Route::resource('ticket-items', TicketItemController::class)->parameters(['ticket-items' => 'record'])->whereNumber('record');
    Route::resource('ticket-categories', TicketCategoryController::class)->parameters(['ticket-categories' => 'record'])->whereNumber('record');
    Route::resource('ticket-priorities', TicketPriorityController::class)->parameters(['ticket-priorities' => 'record'])->whereNumber('record');

    // Vendors.
    Route::get('vendors/save-filtered-table', [VendorController::class, 'saveFilteredTable'])->name('vendors.saveFilteredTable');
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
