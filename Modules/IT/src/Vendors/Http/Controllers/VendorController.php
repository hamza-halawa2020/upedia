<?php

namespace Modules\IT\Vendors\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\IT\SavedTables\Actions\SaveExportTable;
use Modules\IT\Vendors\Actions\CreateVendor;
use Modules\IT\Vendors\Actions\DeleteVendor;
use Modules\IT\Vendors\Actions\UpdateVendor;
use Modules\IT\Vendors\Exports\VendorsExport;
use Modules\IT\Vendors\Http\Requests\ExportVendorsRequest;
use Modules\IT\Vendors\Http\Requests\ListVendorsRequest;
use Modules\IT\Vendors\Http\Requests\VendorRequest;
use Modules\IT\Vendors\Queries\FindVendor;
use Modules\IT\Vendors\Queries\ListVendors;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:it_vendors_index')->only(['index', 'export', 'saveFilteredTable']);
        $this->middleware('check.permission:it_vendors_create')->only(['create', 'store']);
        $this->middleware('check.permission:it_vendors_show')->only('show');
        $this->middleware('check.permission:it_vendors_edit')->only(['edit', 'update']);
        $this->middleware('check.permission:it_vendors_destroy')->only('destroy');
    }

    public function index(ListVendorsRequest $request, ListVendors $query)
    {
        return view('it::vendors.index', ['vendors' => $query->handle($request->validated())]);
    }

    public function create()
    {
        return view('it::vendors.create');
    }

    public function store(VendorRequest $request, CreateVendor $action)
    {
        $action->handle($request->validated(), $request->user());

        return redirect()->route('it.vendors.index')->with('success', 'Vendor created successfully.');
    }

    public function show(int $vendor, FindVendor $query)
    {
        return view('it::vendors.show', ['vendor' => $query->handle($vendor)]);
    }

    public function edit(int $vendor, FindVendor $query)
    {
        return view('it::vendors.edit', ['vendor' => $query->handle($vendor)]);
    }

    public function update(VendorRequest $request, int $vendor, UpdateVendor $action)
    {
        $action->handle($vendor, $request->validated(), $request->user());

        return redirect()->route('it.vendors.index')->with('success', 'Vendor updated successfully.');
    }

    public function destroy(int $vendor, DeleteVendor $action)
    {
        $action->handle($vendor, auth()->user());

        return redirect()->route('it.vendors.index')->with('success', 'Vendor and its assets deleted successfully.');
    }

    public function export(ExportVendorsRequest $request)
    {
        return Excel::download(new VendorsExport($request->validated()),
            'vendors.'.$request->validated('format', 'xlsx'));
    }

    public function saveFilteredTable(ListVendorsRequest $request, ListVendors $query, SaveExportTable $save)
    {
        $criteria = $request->safe()->except('per_page');
        $save->handle(new VendorsExport($criteria), 'Vendors', Vendor::class,
            $criteria, $query->query($criteria)->count());

        return redirect()->route('it.filtered_tables.index')->with('success', 'Vendor table saved.');
    }
}
