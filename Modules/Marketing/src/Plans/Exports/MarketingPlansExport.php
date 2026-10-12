<?php

namespace Modules\Marketing\Plans\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MarketingPlansExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private readonly Collection $plans)
    {
    }

    public function collection(): Collection
    {
        return $this->plans;
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Platform', 'Subject', 'Created By', 'Published Date', 'Status'];
    }

    public function map($plan): array
    {
        return [
            $plan->id,
            $plan->name,
            ucfirst($plan->platform),
            ucfirst($plan->subject),
            trim(($plan->staff?->first_name ?? '').' '.($plan->staff?->last_name ?? '')),
            $plan->publish_date ? Carbon::parse($plan->publish_date)->format('Y-m-d') : 'N/A',
            ucfirst(str_replace('-', ' ', $plan->status)),
        ];
    }
}

