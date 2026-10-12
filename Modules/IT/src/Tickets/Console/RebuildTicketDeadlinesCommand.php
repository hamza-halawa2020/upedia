<?php

namespace Modules\IT\Tickets\Console;

use App\Models\FirebaseNotificationConfig;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\IT\Tickets\Services\BusinessDeadline;

class RebuildTicketDeadlinesCommand extends Command
{
    protected $signature = 'it:tickets:rebuild-deadlines {--apply : Write reconstructed deadlines}';

    protected $description = 'Preview or reconstruct missing deadlines using priority SLA hours and item minutes';

    public function handle(BusinessDeadline $deadline): int
    {
        $config = FirebaseNotificationConfig::query()->orderBy('id')->first();
        $count = 0;
        Ticket::with(['ticketPriority', 'item'])->whereNull('resolution_time')->whereNotNull('created_at')
            ->chunkById(100, function ($tickets) use ($deadline, $config, &$count) {
                foreach ($tickets as $ticket) {
                    $minutes = (int) round((float) ($ticket->ticketPriority?->sla_hours ?? 0) * 60)
                        + ($ticket->item?->is_sla ? (int) $ticket->item->resolution_time : 0);
                    if ($minutes <= 0) {
                        continue;
                    }
                    $value = $deadline->add(Carbon::parse($ticket->created_at), $minutes,
                        $config->working_hour_start ?? 8, $config->working_hour_end ?? 16);
                    if ($this->option('apply')) {
                        Ticket::whereKey($ticket->id)->whereNull('resolution_time')->update([
                            'resolution_time' => $value->format('Y-m-d H:i:s'),
                            'item_resolution_time' => $minutes,
                            'first_notification_sent' => false, 'second_notification_sent' => false,
                        ]);
                    }
                    $count++;
                }
            });
        $this->info(($this->option('apply') ? 'Rebuilt ' : 'Would rebuild ').$count.' deadlines.');

        return self::SUCCESS;
    }
}
