<?php

namespace Modules\IT\Reports\Queries;

use App\Models\SmHumanDepartment;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReportClassification
{
    public function getClassification(Carbon $start, Carbon $end): Collection
    {
        $rows = DB::table('tickets')
            ->join('ticket_categories', 'tickets.ticket_category_id', '=', 'ticket_categories.id')
            ->select('ticket_categories.id', 'ticket_categories.name', DB::raw('COUNT(tickets.id) as total'))
            ->whereBetween('tickets.created_at', [$start, $end])
            ->groupBy('ticket_categories.id', 'ticket_categories.name')
            ->orderByDesc('total')
            ->get();

        $total = (int) $rows->sum('total');

        return $rows->map(function ($row) use ($total) {
            $row->percentage = $total > 0 ? round(($row->total / $total) * 100, 1) : 0;

            return $row;
        });
    }

    public function getDepartmentPerformance(Carbon $start, Carbon $end): Collection
    {
        $rows = SmHumanDepartment::query()
            ->leftJoin('sm_staffs', 'sm_human_departments.id', '=', 'sm_staffs.department_id')
            ->leftJoin('tickets', function ($join) use ($start, $end) {
                $join->on('sm_staffs.id', '=', 'tickets.requester_id')
                    ->whereBetween('tickets.created_at', [$start, $end]);
            })
            ->select('sm_human_departments.id', 'sm_human_departments.name', DB::raw('COUNT(tickets.id) as total_tickets'))
            ->groupBy('sm_human_departments.id', 'sm_human_departments.name')
            ->orderByDesc('total_tickets')
            ->get();

        $highest = (int) optional($rows->first())->total_tickets;

        return $rows->map(function ($row) use ($highest) {
            $row->load_ratio = $highest > 0 ? round(($row->total_tickets / $highest) * 100, 1) : 0;

            return $row;
        });
    }

    public function getRecurringIssues(Carbon $start, Carbon $end): Collection
    {
        return DB::table('tickets')
            ->leftJoin('ticket_items', 'tickets.ticket_item_id', '=', 'ticket_items.id')
            ->leftJoin('ticket_categories as sub_categories', 'tickets.ticket_subcategory_id', '=', 'sub_categories.id')
            ->leftJoin('ticket_categories as main_categories', 'tickets.ticket_category_id', '=', 'main_categories.id')
            ->selectRaw("COALESCE(NULLIF(ticket_items.name, ''), NULLIF(sub_categories.name, ''), NULLIF(main_categories.name, ''), tickets.title) as label")
            ->selectRaw('COUNT(tickets.id) as total')
            ->whereBetween('tickets.created_at', [$start, $end])
            ->groupBy('label')
            ->orderByDesc('total')
            ->limit(10)
            ->get();
    }
}
