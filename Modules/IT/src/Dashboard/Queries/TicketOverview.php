<?php

namespace Modules\IT\Dashboard\Queries;

use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class TicketOverview
{
    public function handle(): array
    {
        $counts = DB::table('tickets')->selectRaw("COUNT(*) as total,
            SUM(CASE WHEN status = 'open' THEN 1 ELSE 0 END) as open,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress,
            SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) as closed")->first();
        $base = Ticket::with(['requester:id,first_name,last_name', 'assignedTo:id,first_name,last_name', 'ticketPriority']);
        $overdue = Ticket::where('status', '!=', 'closed')->whereNotNull('resolution_time')->where('resolution_time', '<', now());

        return ['counts' => $counts, 'overdueCount' => (clone $overdue)->count(),
            'latest' => (clone $base)->latest('id')->limit(10)->get(),
            'overdue' => $overdue->with(['requester:id,first_name,last_name', 'assignedTo:id,first_name,last_name', 'ticketPriority'])->latest('id')->limit(10)->get(),
            'priorities' => DB::table('tickets')->join('ticket_priorities', 'ticket_priorities.id', '=', 'tickets.ticket_priority_id')
                ->where('tickets.status', '!=', 'closed')->select('ticket_priorities.name')
                ->selectRaw('COUNT(*) as total')->groupBy('ticket_priorities.name')->orderByDesc('total')->get()];
    }
}
