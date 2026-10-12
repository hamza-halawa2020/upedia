<?php

namespace Modules\Marketing\Scripts\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Marketing\Scripts\Actions\AuthorizeScriptAccess;
use Modules\Marketing\Scripts\Actions\CreateScript;
use Modules\Marketing\Scripts\Actions\DeleteScript;
use Modules\Marketing\Scripts\Actions\UpdateScript;
use Modules\Marketing\Scripts\Exports\ScriptsExport;
use Modules\Marketing\Scripts\Http\Requests\ListScriptsRequest;
use Modules\Marketing\Scripts\Http\Requests\ScriptRequest;
use Modules\Marketing\Scripts\Queries\FindScript;
use App\Queries\ListDepartments;
use Modules\Marketing\Scripts\Queries\ListScripts;

class ScriptController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:marketing_scripts_create')->only(['create', 'store']);
        $this->middleware('check.permission:marketing_scripts_destroy')->only(['destroy']);
    }

    public function index(ListScriptsRequest $request, ListScripts $scripts, ListDepartments $departments)
    {
        return view('marketing::scripts.index', [
            'scripts' => $scripts->paginate($request->criteria(), Auth::user()),
            'departments' => $departments->handle(),
        ]);
    }

    public function create(ListDepartments $departments)
    {
        return view('marketing::scripts.create', [
            'departments' => $departments->handle(),
            'staff' => Auth::user()->staff,
        ]);
    }

    public function store(ScriptRequest $request, CreateScript $create): RedirectResponse
    {
        $create->handle(Auth::user(), $request->payload(), $request->file('attachments'));

        return redirect()->route('scripts.index')->with('success', 'Script created successfully.');
    }

    public function show(int $script, FindScript $find, AuthorizeScriptAccess $authorize)
    {
        $scr = $find->handle($script);
        $authorize->handle(Auth::user(), $scr, 'view');

        return view('marketing::scripts.show', compact('scr'));
    }

    public function edit(int $script, FindScript $find, AuthorizeScriptAccess $authorize, ListDepartments $departments)
    {
        $scr = $find->handle($script);
        $authorize->handle(Auth::user(), $scr, 'edit');

        return view('marketing::scripts.edit', ['scr' => $scr, 'departments' => $departments->handle(), 'staff' => Auth::user()->staff]);
    }

    public function update(int $script, ScriptRequest $request, FindScript $find, AuthorizeScriptAccess $authorize, UpdateScript $update)
    {
        $authorize->handle(Auth::user(), $find->handle($script), 'edit');
        $updated = $update->handle(Auth::user(), $script, $request->payload(), $request->file('attachments'));

        return redirect()->route('scripts.show', $updated->id)->with('success', 'Script updated successfully.');
    }

    public function destroy(int $script, FindScript $find, AuthorizeScriptAccess $authorize, DeleteScript $delete): RedirectResponse
    {
        $authorize->handle(Auth::user(), $find->handle($script), 'delete');
        $delete->handle($script);

        return redirect()->route('scripts.index')->with('success', 'Script deleted successfully.');
    }

    public function export(ListScriptsRequest $request, ListScripts $scripts)
    {
        $items = $scripts->collection($request->criteria(), Auth::user());

        return Excel::download(new ScriptsExport($items), 'marketing_scripts.xlsx');
    }
}

