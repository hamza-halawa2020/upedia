<?php

namespace Modules\IT\SavedTables\Queries;

use App\Models\FilteredTable;
use Illuminate\Support\Facades\Storage;

class SavedTableFile
{
    public function path(FilteredTable $table): string
    {
        $path = (string) $table->file_path;
        abort_unless(preg_match('#^filtered_tables/[a-zA-Z0-9_.-]+$#D', $path), 404);
        $disk = Storage::disk('public');
        $root = realpath($disk->path('filtered_tables'));
        $file = realpath($disk->path($path));
        abort_unless($root && $file && is_file($file)
            && str_starts_with($file, $root.DIRECTORY_SEPARATOR), 404);

        return $file;
    }
}
