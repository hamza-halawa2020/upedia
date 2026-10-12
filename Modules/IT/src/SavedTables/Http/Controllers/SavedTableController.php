<?php

namespace Modules\IT\SavedTables\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\IT\SavedTables\Actions\DeleteSavedTable;
use Modules\IT\SavedTables\Queries\PreviewSavedTable;
use Modules\IT\SavedTables\Queries\RestoreSavedTable;
use Modules\IT\SavedTables\Queries\SavedTableFile;
use Modules\IT\SavedTables\Queries\SavedTables;

class SavedTableController extends Controller
{
    public function index(SavedTables $tables)
    {
        return view('it::saved-tables.index', ['tables' => $tables->list()]);
    }

    public function restore(int $filteredTable, SavedTables $tables, RestoreSavedTable $restore)
    {
        return redirect()->to($restore->handle($tables->find($filteredTable)));
    }

    public function view(int $filteredTable, SavedTables $tables, SavedTableFile $files, PreviewSavedTable $preview)
    {
        $table = $tables->find($filteredTable);
        $path = $files->path($table);
        if (strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'pdf') {
            return response()->file($path, ['Content-Type' => 'application/pdf', 'X-Content-Type-Options' => 'nosniff']);
        }

        if (in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), ['xlsx', 'xls', 'csv'], true)) {
            return view('it::saved-tables.preview', ['table' => $table] + $preview->handle($path));
        }

        return response()->download($path);
    }

    public function download(int $filteredTable, SavedTables $tables, SavedTableFile $files)
    {
        return response()->download($files->path($tables->find($filteredTable)));
    }

    public function destroy(int $filteredTable, DeleteSavedTable $delete)
    {
        $delete->handle($filteredTable);

        return redirect()->route('it.filtered_tables.index')->with('success', 'Saved table deleted.');
    }
}
