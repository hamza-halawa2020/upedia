<?php

namespace Modules\IT\Dashboard\Queries;

use Illuminate\Support\Facades\DB;

class TicketWorkload
{
    public function handle(): array
    {
        $staff = DB::table('sm_staffs')->join('sm_human_departments', 'sm_human_departments.id', '=', 'sm_staffs.department_id')
            ->where('sm_human_departments.slug', 'it')->where('sm_staffs.active_status', '!=', 0)
            ->select('sm_staffs.id', 'sm_staffs.first_name', 'sm_staffs.last_name')->get();
        $totals = DB::table('tickets')->whereIn('assigned_to', $staff->pluck('id'))
            ->whereBetween('created_at', [now()->subDays(7), now()])->select('assigned_to')
            ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'open' THEN 1 ELSE 0 END) as open,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress,
                SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) as closed")
            ->groupBy('assigned_to')->get()->keyBy('assigned_to');

        return [
            'closedToday' => DB::table('tickets')->where('status', 'closed')->whereDate('closed_at', today())->count(),
            'reopenedWeek' => DB::table('tickets')->where('updated_at', '>=', now()->subWeek())->sum('reopen_count'),
            'workload' => $staff->map(function ($person) use ($totals) {
                $row = $totals->get($person->id);

                return ['name' => trim($person->first_name.' '.$person->last_name), 'total' => (int) ($row->total ?? 0),
                    'open' => (int) ($row->open ?? 0), 'pending' => (int) ($row->pending ?? 0),
                    'in_progress' => (int) ($row->in_progress ?? 0), 'closed' => (int) ($row->closed ?? 0)];
            }),
        ];
    }
}
