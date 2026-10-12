<?php

namespace Modules\IT\Purchases\Http\Controllers;

use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\IT\Purchases\Actions\ChangePurchaseStatus;
use Modules\IT\Purchases\Actions\DeletePurchase;
use Modules\IT\Purchases\Actions\SavePurchase;
use Modules\IT\Purchases\Actions\SavePurchaseTable;
use Modules\IT\Purchases\Exports\PurchasesExport;
use Modules\IT\Purchases\Http\Requests\ChangePurchaseStatusRequest;
use Modules\IT\Purchases\Http\Requests\ListPurchasesRequest;
use Modules\IT\Purchases\Http\Requests\SavePurchaseRequest;
use Modules\IT\Purchases\Queries\Purchases;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:it_purchase_update_status')->only('updateStatus');
        $this->middleware('check.permission:it_purchase_index')->only(['index', 'export', 'saveFilteredTable']);
        $this->middleware('check.permission:it_purchase_create')->only(['create', 'store']);
        $this->middleware('check.permission:it_purchase_show')->only('show');
        $this->middleware('check.permission:it_purchase_edit')->only(['edit', 'update']);
        $this->middleware('check.permission:it_purchase_destroy')->only('destroy');
    }

    public function index(ListPurchasesRequest $request, Purchases $query)
    {
        return view('it::purchase.index', ['purchases' => $query->list($request->validated())]);
    }

    public function create(Purchases $query)
    {
        return view('it::purchase.form', ['purchase' => null] + $query->options());
    }

    public function store(SavePurchaseRequest $request, SavePurchase $save)
    {
        $save->handle($request->validated());

        return redirect()->route('it.purchase.index')->with('success', 'Purchase created.');
    }

    public function show(int $purchase, Purchases $query)
    {
        return view('it::purchase.show', ['purchase' => $query->find($purchase)]);
    }

    public function edit(int $purchase, Purchases $query)
    {
        $record = $query->find($purchase);
        abort_unless($record->status === 'pending', 409, 'Only pending purchases can be edited.');

        return view('it::purchase.form', ['purchase' => $record] + $query->options());
    }

    public function update(SavePurchaseRequest $request, int $purchase, SavePurchase $save)
    {
        $save->handle($request->validated(), $purchase);

        return redirect()->route('it.purchase.index')->with('success', 'Purchase updated.');
    }

    public function destroy(int $purchase, DeletePurchase $delete)
    {
        $delete->handle($purchase);

        return redirect()->route('it.purchase.index')->with('success', 'Purchase deleted.');
    }

    public function export(ListPurchasesRequest $request)
    {
        return Excel::download(new PurchasesExport($request->validated()), 'purchases.'.$request->validated('format', 'xlsx'));
    }

    public function saveFilteredTable(ListPurchasesRequest $request, SavePurchaseTable $save)
    {
        $save->handle($request->validated());

        return redirect()->route('it.filtered_tables.index')->with('success', 'Purchase table saved.');
    }

    public function updateStatus(ChangePurchaseStatusRequest $request, ChangePurchaseStatus $change)
    {
        $change->handle((int) $request->validated('purchase_id'), $request->validated('status'),
            $request->validated('expense_head_id'), $request->user()->id);

        return redirect()->route('it.purchase.index')->with('success', 'Purchase status updated.');
    }
}
