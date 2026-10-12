<?php

namespace Modules\IT\Tickets\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\IT\Tickets\Queries\Tickets;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;

class TicketsExport extends StringValueBinder implements FromQuery, WithCustomValueBinder, WithHeadings, WithMapping
{
    public function __construct(private readonly array $criteria) {}

    public function query()
    {
        return app(Tickets::class)->query($this->criteria);
    }

    public function headings(): array
    {
        return ['ID', 'Title', 'Category', 'Priority', 'Requester', 'Assignee', 'Status', 'Deadline'];
    }

    public function map($ticket): array
    {
        return [$ticket->id, $ticket->title, $ticket->category?->name, $ticket->ticketPriority?->name,
            trim(($ticket->requester?->first_name ?? '').' '.($ticket->requester?->last_name ?? '')),
            trim(($ticket->assignedTo?->first_name ?? '').' '.($ticket->assignedTo?->last_name ?? '')),
            $ticket->status, $ticket->resolution_time];
    }
}
