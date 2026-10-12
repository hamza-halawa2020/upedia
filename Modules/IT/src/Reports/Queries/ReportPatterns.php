<?php

namespace Modules\IT\Reports\Queries;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ReportPatterns
{
    public function getTimePatterns(Carbon $start, Carbon $end): array
    {
        $dayMap = [
            1 => 'Sunday',
            2 => 'Monday',
            3 => 'Tuesday',
            4 => 'Wednesday',
            5 => 'Thursday',
            6 => 'Friday',
            7 => 'Saturday',
        ];

        $days = Ticket::query()
            ->selectRaw('DAYOFWEEK(created_at) as slot')
            ->selectRaw('COUNT(*) as total')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('slot')
            ->orderBy('slot')
            ->get()
            ->map(function ($row) use ($dayMap) {
                return [
                    'label' => $dayMap[(int) $row->slot] ?? 'Unknown',
                    'total' => (int) $row->total,
                ];
            });

        $hours = Ticket::query()
            ->selectRaw('HOUR(created_at) as slot')
            ->selectRaw('COUNT(*) as total')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('slot')
            ->orderBy('slot')
            ->get()
            ->map(function ($row) {
                $hour = (int) $row->slot;

                return [
                    'label' => str_pad((string) $hour, 2, '0', STR_PAD_LEFT).':00',
                    'total' => (int) $row->total,
                    'slot' => $hour,
                ];
            });

        $peakDay = $days->sortByDesc('total')->first();
        $peakHour = $hours->sortByDesc('total')->first();

        return [
            'days' => $days->values(),
            'hours' => $hours->values(),
            'peak_day' => $peakDay['label'] ?? 'N/A',
            'peak_hour' => $peakHour['label'] ?? 'N/A',
        ];
    }

    public function getInternetPattern(Carbon $start, Carbon $end): array
    {
        $internetTickets = Ticket::query()
            ->leftJoin('ticket_categories', 'tickets.ticket_category_id', '=', 'ticket_categories.id')
            ->whereBetween('tickets.created_at', [$start, $end])
            ->where(function ($query) {
                $query->where('tickets.title', 'like', '%internet%')
                    ->orWhere('tickets.title', 'like', '%network%')
                    ->orWhere('tickets.description', 'like', '%internet%')
                    ->orWhere('tickets.description', 'like', '%network%')
                    ->orWhere('ticket_categories.name', 'like', '%internet%')
                    ->orWhere('ticket_categories.name', 'like', '%network%')
                    ->orWhere('ticket_categories.name', 'like', '%connection%');
            });

        $peakHour = (clone $internetTickets)
            ->selectRaw('HOUR(tickets.created_at) as hour_slot, COUNT(*) as total')
            ->groupBy('hour_slot')
            ->orderByDesc('total')
            ->orderBy('hour_slot')
            ->first();

        $peakDay = (clone $internetTickets)
            ->selectRaw('DAYOFWEEK(tickets.created_at) as day_slot, COUNT(*) as total')
            ->groupBy('day_slot')
            ->orderByDesc('total')
            ->orderBy('day_slot')
            ->first();

        $dayMap = [
            1 => 'Sunday',
            2 => 'Monday',
            3 => 'Tuesday',
            4 => 'Wednesday',
            5 => 'Thursday',
            6 => 'Friday',
            7 => 'Saturday',
        ];

        return [
            'total' => (clone $internetTickets)->count(),
            'peak_hour' => $peakHour ? str_pad((string) $peakHour->hour_slot, 2, '0', STR_PAD_LEFT).':00' : 'N/A',
            'peak_day' => $peakDay ? ($dayMap[(int) $peakDay->day_slot] ?? 'N/A') : 'N/A',
        ];
    }

    public function getReopenedIssues(Carbon $start): Collection
    {
        return Ticket::query()
            ->select('id', 'title', 'reopen_count', 'status', 'updated_at')
            ->where('reopen_count', '>', 0)
            ->where('updated_at', '>=', $start)
            ->orderByDesc('reopen_count')
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();
    }
}
