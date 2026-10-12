<?php

namespace Modules\IT\Reports\Queries;

use App\Models\Ticket;
use Carbon\Carbon;

class ReportTotals
{
    public function __construct(private readonly ReportResolution $reportResolution) {}

    public function getTotals(Carbon $start, Carbon $end): array
    {
        $query = Ticket::whereBetween('created_at', [$start, $end]);

        $resolutionMetrics = $this->reportResolution->getResolutionMetrics($start, $end);

        return [
            'total' => (clone $query)->count(),
            'open' => (clone $query)->where('status', 'open')->count(),
            'in_progress' => (clone $query)->where('status', 'in_progress')->count(),
            'closed' => (clone $query)->where('status', 'closed')->count(),
            'overdue' => (clone $query)->where('status', '!=', 'closed')->whereNotNull('resolution_time')->where('resolution_time', '<', now())->count(),
            'reopened' => (int) (clone $query)->sum('reopen_count'),
            'avg_resolution' => $resolutionMetrics['average'],
        ];
    }

    public function getRealTimeData(): array
    {
        return [
            'currently_open' => Ticket::where('status', 'open')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'closed_today' => Ticket::where('status', 'closed')
                ->whereDate('closed_at', today())
                ->count(),
            'reopened_this_week' => Ticket::where('updated_at', '>=', now()->subWeek())
                ->where('reopen_count', '>', 0)
                ->sum('reopen_count'),
            'overdue' => Ticket::where('status', '!=', 'closed')->whereNotNull('resolution_time')->where('resolution_time', '<', now())->count(),
        ];
    }
}
