<?php

namespace Modules\IT\SavedTables\Actions;

use App\Models\FilteredTable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class SaveExportTable
{
    public function handle(object $export, string $label, string $model, array $criteria, int $count): void
    {
        $name = Str::slug($label).'_'.Str::uuid().'.xlsx';
        $path = 'filtered_tables/'.$name;
        try {
            if (! Excel::store($export, $path, 'public')) {
                throw new \RuntimeException('Could not save export.');
            }
            (new FilteredTable)->forceFill(['project' => 'it', 'table_name' => $label, 'model' => $model,
                'file_name' => $name, 'file_path' => $path, 'file_url' => Storage::disk('public')->url($path),
                'filters' => $criteria, 'total_rows' => $count])->save();
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($path);
            throw $exception;
        }
    }
}
