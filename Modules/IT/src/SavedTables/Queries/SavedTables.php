<?php

namespace Modules\IT\SavedTables\Queries;

use App\Models\FilteredTable;

class SavedTables
{
    public function list()
    {
        return FilteredTable::where('project', 'it')->latest('id')->paginate(10)->withQueryString();
    }

    public function find(int $id): FilteredTable
    {
        return FilteredTable::where('project', 'it')->findOrFail($id);
    }
}
