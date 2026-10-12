<?php

namespace Modules\IT\Assets\Http\Controllers;

use App\Models\Asset;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\IT\Assets\Actions\DeleteAsset;
use Modules\IT\Assets\Actions\SaveAsset;
use Modules\IT\Assets\Exports\AssetsExport;
use Modules\IT\Assets\Http\Requests\ListAssetsRequest;
use Modules\IT\Assets\Http\Requests\SaveAssetRequest;
use Modules\IT\Assets\Queries\Assets;
use Modules\IT\SavedTables\Actions\SaveExportTable;

class AssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:it_assets_index')->only(['index', 'export', 'saveFilteredTable']);
        $this->middleware('check.permission:it_assets_create')->only(['create', 'store']);
        $this->middleware('check.permission:it_assets_show')->only('show');
        $this->middleware('check.permission:it_assets_edit')->only(['edit', 'update']);
        $this->middleware('check.permission:it_assets_destroy')->only('destroy');
    }

    public function index(ListAssetsRequest $request, Assets $query)
    {
        return view('it::assets.index', ['assets' => $query->list($request->validated())]);
    }

    public function create(Assets $query)
    {
        return view('it::assets.form', ['asset' => null] + $query->options());
    }

    public function store(SaveAssetRequest $request, SaveAsset $save)
    {
        $save->handle($request->validated());

        return redirect()->route('it.asset.index')->with('success', 'Asset created.');
    }

    public function show(int $asset, Assets $query)
    {
        return view('it::assets.show', ['asset' => $query->find($asset)]);
    }

    public function edit(int $asset, Assets $query)
    {
        return view('it::assets.form', ['asset' => $query->find($asset)] + $query->options());
    }

    public function update(SaveAssetRequest $request, int $asset, SaveAsset $save)
    {
        $save->handle($request->validated(), $asset);

        return redirect()->route('it.asset.show', $asset)->with('success', 'Asset updated.');
    }

    public function destroy(int $asset, DeleteAsset $delete)
    {
        $delete->handle($asset);

        return redirect()->route('it.asset.index')->with('success', 'Asset deleted.');
    }

    public function export(ListAssetsRequest $request)
    {
        return Excel::download(new AssetsExport($request->validated()), 'assets.'.$request->validated('format', 'xlsx'));
    }

    public function saveFilteredTable(ListAssetsRequest $request, Assets $query, SaveExportTable $save)
    {
        $criteria = $request->safe()->except(['format', 'per_page']);
        $save->handle(new AssetsExport($criteria), 'Assets', Asset::class, $criteria, $query->query($criteria)->count());

        return redirect()->route('it.filtered_tables.index')->with('success', 'Asset table saved.');
    }
}
