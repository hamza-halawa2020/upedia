<?php

namespace Modules\IT\Vendors\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;
use Modules\IT\Vendors\Queries\ListVendors;

class VendorsExport extends StringValueBinder implements FromQuery, WithHeadings, WithMapping, WithCustomValueBinder
{
    public function __construct(private readonly array $criteria) {}

    public function query(): Builder
    {
        return app(ListVendors::class)->query($this->criteria);
    }

    public function headings(): array
    {
        return ['ID', 'Vendor', 'Vendor Code', 'Phone', 'Location', 'Tax', 'Shipping'];
    }

    public function map($vendor): array
    {
        return [$vendor->id, $vendor->name, '#VN-'.str_pad($vendor->id, 4, '0', STR_PAD_LEFT),
            $vendor->phone, $vendor->location, $vendor->tax, $vendor->shipping_cost];
    }
}
