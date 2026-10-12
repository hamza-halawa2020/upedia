<?php

namespace Modules\IT\Expenses\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\IT\Expenses\Queries\Expenses;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;

class ExpensesExport extends StringValueBinder implements FromQuery, WithCustomValueBinder, WithHeadings, WithMapping
{
    public function __construct(private readonly array $criteria) {}

    public function query()
    {
        return app(Expenses::class)->query($this->criteria);
    }

    public function headings(): array
    {
        return ['ID', 'Item', 'Vendors', 'Amount', 'Payment Date', 'Payment Method', 'Status', 'Recurring'];
    }

    public function map($expense): array
    {
        return [$expense->id, $expense->item_name, $expense->vendors, $expense->amount,
            $expense->payment_date?->format('Y-m-d'), $expense->payment_method, $expense->status, $expense->recurring];
    }
}
