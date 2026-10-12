<?php

namespace Modules\IT\TicketConfiguration\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\IT\TicketConfiguration\Actions\DeleteCatalogRecord;
use Modules\IT\TicketConfiguration\Actions\SaveCatalogRecord;
use Modules\IT\TicketConfiguration\Catalog;
use Modules\IT\TicketConfiguration\Http\Requests\ListCatalogRequest;
use Modules\IT\TicketConfiguration\Http\Requests\TicketCategoryRequest;
use Modules\IT\TicketConfiguration\Queries\CatalogRecords;

class TicketCategoryController extends Controller
{
    public function index(ListCatalogRequest $request, CatalogRecords $records)
    {
        $catalog = Catalog::Categories;
        return view('it::ticket-configuration.index', [
            'catalog' => $catalog, 'records' => $records->list($catalog, $request->validated()),
        ]);
    }

    public function create(Request $request, CatalogRecords $records)
    {
        $catalog = Catalog::Categories;
        return view('it::ticket-configuration.form', ['catalog' => $catalog, 'record' => null] + $records->options($catalog));
    }

    public function store(TicketCategoryRequest $request, SaveCatalogRecord $save)
    {
        $catalog = Catalog::Categories;
        $save->handle($catalog, $request->validated());
        return redirect()->route('it.'.$catalog->value.'.index')->with('success', 'Created successfully.');
    }

    public function show(Request $request, CatalogRecords $records)
    {
        $catalog = Catalog::Categories;
        return view('it::ticket-configuration.show', [
            'catalog' => $catalog, 'record' => $records->find($catalog, (int) $request->route('record')),
        ]);
    }

    public function edit(Request $request, CatalogRecords $records)
    {
        $catalog = Catalog::Categories;
        return view('it::ticket-configuration.form', [
            'catalog' => $catalog, 'record' => $records->find($catalog, (int) $request->route('record')),
        ] + $records->options($catalog));
    }

    public function update(TicketCategoryRequest $request, SaveCatalogRecord $save)
    {
        $catalog = Catalog::Categories;
        $save->handle($catalog, $request->validated(), (int) $request->route('record'));
        return redirect()->route('it.'.$catalog->value.'.index')->with('success', 'Updated successfully.');
    }

    public function destroy(Request $request, DeleteCatalogRecord $delete)
    {
        $catalog = Catalog::Categories;
        $delete->handle($catalog, (int) $request->route('record'));
        return redirect()->route('it.'.$catalog->value.'.index')->with('success', 'Deleted successfully.');
    }
}
