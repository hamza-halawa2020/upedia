<?php

namespace Modules\Marketing\Scripts\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ScriptsExport implements FromCollection, WithHeadings
{
    public function __construct(private readonly Collection $scripts)
    {
    }

    public function collection(): Collection
    {
        return $this->scripts->map(fn ($script) => [
            'Title' => $script->title,
            'Category Name' => $script->category_name,
            'Visibility' => $script->visibility,
            'Status' => $script->status,
            'Departments' => $script->departments->pluck('name')->implode(', '),
            'Created At' => $script->created_at?->toDateTimeString(),
        ]);
    }

    public function headings(): array
    {
        return ['Title', 'Category Name', 'Visibility', 'Status', 'Departments', 'Created At'];
    }
}

