<?php

namespace Modules\IT\Reports\Builders;

use Carbon\Carbon;

class ReportLinks
{
    public function handle(Carbon $start, Carbon $end, ?int $departmentId): array
    {
        $dates = ['start_date' => $start->format('Y-m-d'), 'end_date' => $end->format('Y-m-d')];

        return [
            'All Tickets' => route('it.tickets.index', $dates),
            'Closed Tickets' => route('it.tickets.index', $dates + ['status' => 'closed']),
            'Reopened Tickets' => route('it.tickets.index', $dates + ['reopened' => 1]),
            'Overdue Tickets' => route('it.tickets.index', ['sla' => 'breached']),
            'Top Department Tickets' => route('it.tickets.index', $dates + ($departmentId ? ['department_id' => $departmentId] : [])),
        ];
    }
}
