<?php

namespace Modules\IT\Purchases\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\IT\Purchases\Queries\Purchases;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;

class PurchasesExport extends StringValueBinder implements FromQuery, WithCustomValueBinder, WithHeadings, WithMapping
{
    public function __construct(private readonly array $criteria) {}

    public function query()
    {
        return app(Purchases::class)->query($this->criteria);
    }

    public function headings(): array
    {
        return ['ID', 'Purchase Number', 'Name', 'Requested By', 'Status', 'Total', 'Created Date'];
    }

    public function map($purchase): array
    {
        return [$purchase->id, $purchase->purchase_number, $purchase->name,
            $purchase->requestedStaffs->map(fn ($staff) => trim($staff->first_name.' '.$staff->last_name))->join(', '),
            $purchase->status, $purchase->total, $purchase->created_at?->format('Y-m-d')];
    }
}
