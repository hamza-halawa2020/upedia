<?php

namespace Modules\IT\Reports\Queries;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReportResolution
{
    public function getResolutionMetrics(Carbon $start, Carbon $end): array
    {
        $summary = Ticket::query()
            ->whereNotNull('closed_at')
            ->whereBetween('closed_at', [$start, $end])
            ->selectRaw('AVG('.$this->durationSql().') as avg_minutes')
            ->selectRaw('MIN('.$this->durationSql().') as min_minutes')
            ->selectRaw('MAX('.$this->durationSql().') as max_minutes')
            ->first();

        $slowestTicket = Ticket::query()
            ->whereNotNull('closed_at')
            ->whereBetween('closed_at', [$start, $end])
            ->select('id', 'title')
            ->selectRaw($this->durationSql().' as resolution_minutes')
            ->orderByDesc('resolution_minutes')
            ->first();

        $fastestTicket = Ticket::query()
            ->whereNotNull('closed_at')
            ->whereBetween('closed_at', [$start, $end])
            ->select('id', 'title')
            ->selectRaw($this->durationSql().' as resolution_minutes')
            ->orderBy('resolution_minutes')
            ->first();

        return [
            'average' => $this->formatMinutes($summary?->avg_minutes),
            'fastest' => $this->formatMinutes($summary?->min_minutes),
            'slowest' => $this->formatMinutes($summary?->max_minutes),
            'fastest_ticket' => $fastestTicket,
            'slowest_ticket' => $slowestTicket,
        ];
    }

    public function formatMinutes($minutes): string
    {
        if ($minutes === null) {
            return 'N/A';
        }

        $minutes = (int) round($minutes);
        $days = intdiv($minutes, 1440);
        $hours = intdiv($minutes % 1440, 60);
        $remainingMinutes = $minutes % 60;

        $parts = [];

        if ($days > 0) {
            $parts[] = $days.'d';
        }

        if ($hours > 0) {
            $parts[] = $hours.'h';
        }

        if ($remainingMinutes > 0 || empty($parts)) {
            $parts[] = $remainingMinutes.'m';
        }

        return implode(' ', $parts);
    }

    public function getResolutionDescriptions(Carbon $start, Carbon $end): Collection
    {
        return Ticket::query()
            ->select('id', 'title', 'resolution_description', 'closed_at')
            ->whereNotNull('closed_at')
            ->whereNotNull('resolution_description')
            ->whereBetween('closed_at', [$start, $end])
            ->latest('closed_at')
            ->limit(8)
            ->get();
    }

    private function durationSql(): string
    {
        return DB::connection()->getDriverName() === 'sqlite'
            ? "CAST((strftime('%s', closed_at) - strftime('%s', created_at)) / 60 AS INTEGER)"
            : 'TIMESTAMPDIFF(MINUTE, created_at, closed_at)';
    }
}
