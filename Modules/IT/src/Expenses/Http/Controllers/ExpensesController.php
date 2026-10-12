<?php

namespace Modules\IT\Expenses\Http\Controllers;

use App\Actions\Exports\DownloadExport;
use Illuminate\Routing\Controller;
use Modules\IT\Expenses\Actions\DeleteExpense;
use Modules\IT\Expenses\Actions\PayExpense;
use Modules\IT\Expenses\Actions\SaveExpense;
use Modules\IT\Expenses\Exports\ExpensesExport;
use Modules\IT\Expenses\Http\Requests\ListExpensesRequest;
use Modules\IT\Expenses\Http\Requests\PayExpenseRequest;
use Modules\IT\Expenses\Http\Requests\SaveExpenseRequest;
use Modules\IT\Expenses\Models\ItExpense;
use Modules\IT\Expenses\Queries\Expenses;
use Modules\IT\SavedTables\Actions\SaveExportTable;

class ExpensesController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:it_expenses_update_status')->only('updateStatus');
        $this->middleware('check.permission:it_expenses_index')->only(['index', 'export', 'saveFilteredTable']);
        $this->middleware('check.permission:it_expenses_create')->only(['create', 'store']);
        $this->middleware('check.permission:it_expenses_show')->only('show');
        $this->middleware('check.permission:it_expenses_edit')->only(['edit', 'update']);
        $this->middleware('check.permission:it_expenses_destroy')->only('destroy');
    }

    public function index(ListExpensesRequest $request, Expenses $query)
    {
        return view('it::expenses.index', ['expenses' => $query->list($request->validated())]);
    }

    public function create(Expenses $query)
    {
        return view('it::expenses.form', ['expense' => null, 'heads' => $query->heads()]);
    }

    public function store(SaveExpenseRequest $request, SaveExpense $save)
    {
        $save->handle($request->validated(), $request->user()->id);

        return redirect()->route('it.expenses.index')->with('success', 'Expense created.');
    }

    public function show(int $expense, Expenses $query)
    {
        return view('it::expenses.show', ['expense' => $query->find($expense)]);
    }

    public function edit(int $expense, Expenses $query)
    {
        $record = $query->find($expense);
        abort_if($record->status === 'paid', 409, 'Paid expenses cannot be edited.');

        return view('it::expenses.form', ['expense' => $record, 'heads' => $query->heads()]);
    }

    public function update(SaveExpenseRequest $request, int $expense, SaveExpense $save)
    {
        $save->handle($request->validated(), $request->user()->id, $expense);

        return redirect()->route('it.expenses.index')->with('success', 'Expense updated.');
    }

    public function destroy(int $expense, DeleteExpense $delete)
    {
        $delete->handle($expense);

        return redirect()->route('it.expenses.index')->with('success', 'Expense deleted.');
    }

    public function export(ListExpensesRequest $request)
    {
        return app(DownloadExport::class)->handle(new ExpensesExport($request->validated()), 'expenses', $request->validated('format', 'xlsx'));
    }

    public function saveFilteredTable(ListExpensesRequest $request, Expenses $query, SaveExportTable $save)
    {
        $criteria = $request->safe()->except(['format', 'per_page']);
        $save->handle(new ExpensesExport($criteria), 'Expenses', ItExpense::class, $criteria, $query->query($criteria)->count());

        return redirect()->route('it.filtered_tables.index')->with('success', 'Expense table saved.');
    }

    public function updateStatus(PayExpenseRequest $request, PayExpense $pay)
    {
        $pay->handle((int) $request->validated('expense_id'), (int) $request->validated('expense_head_id'), $request->user()->id);

        return redirect()->route('it.expenses.index')->with('success', 'Expense paid.');
    }
}
