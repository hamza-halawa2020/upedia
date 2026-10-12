<?php

namespace App\Actions\Exports;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class DownloadExport
{
    public function handle(object $export, string $name, string $format)
    {
        if ($format !== 'pdf') { return Excel::download($export, $name.'.'.$format); }
        $query = $export->query();
        if ((clone $query)->count() > 1000) {
            throw ValidationException::withMessages(['format' => 'Narrow the filters to 1000 rows or fewer for PDF.']);
        }
        $rows = $query->get()->map(fn ($record) => $export->map($record));
        return Pdf::loadView('exports.table', ['title' => ucfirst($name),
            'headings' => $export->headings(), 'rows' => $rows])
            ->setOptions(['isRemoteEnabled' => false, 'isPhpEnabled' => false, 'defaultFont' => 'DejaVu Sans'])
            ->setPaper('a4', 'landscape')->download($name.'.pdf');
    }
}
