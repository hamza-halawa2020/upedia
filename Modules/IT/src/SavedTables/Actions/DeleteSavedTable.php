<?php

namespace Modules\IT\SavedTables\Actions;

use App\Models\FilteredTable;
use Illuminate\Support\Facades\DB;
use Modules\IT\SavedTables\Queries\SavedTableFile;

class DeleteSavedTable
{
    public function __construct(private readonly SavedTableFile $files) {}

    public function handle(int $id): void
    {
        DB::transaction(function () use ($id) {
            $table = FilteredTable::where('project', 'it')->lockForUpdate()->findOrFail($id);
            $path = $this->files->path($table);
            $table->delete();
            DB::afterCommit(fn () => unlink($path));
        });
    }
}
