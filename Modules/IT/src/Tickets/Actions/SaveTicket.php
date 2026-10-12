<?php

namespace Modules\IT\Tickets\Actions;

use App\Actions\Attachments\WithAttachments;
use App\Models\FirebaseNotificationConfig;
use App\Models\Ticket;
use Illuminate\Support\Arr;
use Modules\IT\Tickets\Services\BusinessDeadline;

class SaveTicket
{
    public function __construct(private readonly BusinessDeadline $deadlines) {}

    public function handle(array $data, int $actorId, ?int $id = null): Ticket
    {
        return app(WithAttachments::class)->handle($data['attachments'] ?? [], 'tickets', function () use ($data, $actorId, $id) {
            $ticket = $id ? Ticket::lockForUpdate()->findOrFail($id) : new Ticket;
            $oldStatus = $ticket->status;
            $ticket->fill(Arr::except($data, ['attachments']));
            if (! $id) {
                $ticket->created_by = $actorId;
            }
            $recalculate = ! $id || $ticket->isDirty(['ticket_priority_id', 'ticket_item_id']);
            if ($ticket->status === 'closed' && ! $ticket->closed_at) {
                $ticket->closed_at = now();
            }
            if ($oldStatus === 'closed' && $ticket->status !== 'closed') {
                $ticket->closed_at = null;
                $ticket->reopen_count = (int) $ticket->reopen_count + 1;
                $ticket->first_notification_sent = false;
                $ticket->second_notification_sent = false;
            }
            $ticket->save();
            if ($recalculate) {
                $ticket->load(['ticketPriority', 'item']);
                $minutes = (int) round((float) ($ticket->ticketPriority?->sla_hours ?? 0) * 60)
                    + ($ticket->item?->is_sla ? (int) $ticket->item->resolution_time : 0);
                $config = FirebaseNotificationConfig::first();
                $ticket->forceFill(['first_notification_sent' => false, 'second_notification_sent' => false, 'item_resolution_time' => $minutes,
                    'resolution_time' => $minutes > 0 ? $this->deadlines->add($ticket->created_at,
                        $minutes, $config->working_hour_start ?? 8, $config->working_hour_end ?? 16)->format('Y-m-d H:i:s') : null])->save();
            }

            return $ticket;
        });
    }
}
