<?php

namespace Modules\IT\Assets\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\IT\Assets\Queries\Assets;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;

class AssetsExport extends StringValueBinder implements FromQuery, WithCustomValueBinder, WithHeadings, WithMapping
{
    public function __construct(private readonly array $criteria) {}

    public function query()
    {
        return app(Assets::class)->query($this->criteria);
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Product', 'Serial', 'Vendor', 'Department', 'Cost', 'Acquired On', 'Status'];
    }

    public function map($asset): array
    {
        return [$asset->id, $asset->name, $asset->product?->name, $asset->serial_number, $asset->vendor?->name,
            $asset->department?->name ?? $asset->user?->staff?->department?->name,
            $asset->total_cost, $asset->acquisition_date?->format('Y-m-d'), $asset->is_currently_in_use];
    }
}
