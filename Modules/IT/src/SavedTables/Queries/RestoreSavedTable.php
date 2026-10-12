<?php

namespace Modules\IT\SavedTables\Queries;

use App\Models\FilteredTable;
use Illuminate\Support\Facades\Route;

class RestoreSavedTable
{
    public function handle(FilteredTable $table): string
    {
        $routes = [
            'App\\Models\\Purchase' => 'it.purchase.index',
            'App\\Models\\Ticket' => 'it.tickets.index',
            'App\\Models\\Assets' => 'it.asset.index',
            'App\\Models\\Asset' => 'it.asset.index',
            'App\\Models\\Vendor' => 'it.vendors.index',
            'App\\Models\\Product' => 'it.products.index',
            'App\\Models\\ItProduct' => 'it.products.index',
            'App\\Models\\Expense' => 'it.expenses.index',
            'Modules\\IT\\Expenses\\Models\\ItExpense' => 'it.expenses.index',
            'App\\Models\\ItSolution' => 'it.it-solutions.index',
        ];
        $route = $routes[$table->model] ?? null;
        abort_unless($route && Route::has($route), 409, 'This table is not migrated yet.');
        $allowed = ['search', 'status', 'assigned_to', 'ticket_priority_id', 'requester_id',
            'start_date', 'end_date', 'from_date', 'to_date', 'staff_id', 'purchase_number', 'recurring', 'per_page'];
        $filters = array_intersect_key((array) $table->filters, array_flip($allowed));

        return route($route, $filters);
    }
}
