<?php

namespace Modules\IT\Tickets\Actions;

use App\Models\FirebaseNotificationConfig;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\IT\Tickets\Services\BusinessMinutes;
use Modules\Notifications\Actions\NotifyActor;

class SendTicketReminders
{
    public function __construct(private readonly BusinessMinutes $minutes, private readonly NotifyActor $notify) {}

    public function handle(): int
    {
        $config = FirebaseNotificationConfig::query()->orderBy('id')->first();
        $now = Carbon::now();
        if (! $config || ! $this->minutes->isWorking($now, $config->working_hour_start, $config->working_hour_end)) {
            return 0;
        }
        $department = DB::table('sm_human_departments')->where('slug', 'it')->value('id');
        if (! $department) {
            return 0;
        }
        $users = User::whereIn('id', DB::table('sm_staffs')->where('department_id', $department)
            ->where('active_status', '!=', 0)->select('user_id'))->get()->keyBy('id');
        $managerIds = DB::table('sm_staffs')->join('hr_job_titles', 'hr_job_titles.id', '=', 'sm_staffs.job_title_id')
            ->where('sm_staffs.department_id', $department)->where('sm_staffs.active_status', '!=', 0)
            ->where('hr_job_titles.slug', 'it-manager')->pluck('sm_staffs.user_id');
        $managers = $users->only($managerIds->all());
        $sent = 0;
        Ticket::whereNotIn('status', ['closed', 'resolved'])->whereNotNull('resolution_time')
            ->where(function ($query) {
                $query->where('first_notification_sent', false)->orWhere('second_notification_sent', false);
            })->chunkById(100, function ($tickets) use ($config, $now, $users, $managers, &$sent) {
                foreach ($tickets as $ticket) {
                    $sent += DB::transaction(function () use ($ticket, $config, $now, $users, $managers) {
                        $ticket = Ticket::lockForUpdate()->find($ticket->id);
                        if (! $ticket || in_array($ticket->status, ['closed', 'resolved']) || ! $ticket->resolution_time) {
                            return 0;
                        }
                        $remaining = $this->minutes->between($now, Carbon::parse($ticket->resolution_time),
                            $config->working_hour_start, $config->working_hour_end);
                        $ticket->remaining_time = $remaining;
                        $count = 0;
                        if (! $ticket->first_notification_sent && $config->first_notification_before > 0
                            && $remaining > 0 && $remaining <= $config->first_notification_before && $users->isNotEmpty()) {
                            foreach ($users as $user) {
                                $this->notify->handle($user, "Ticket #{$ticket->id} has {$remaining} business minutes remaining.",
                                    'Ticket approaching deadline', ['it.tickets.show', $ticket->id]);
                            }
                            $ticket->first_notification_sent = true;
                            $count++;
                        }
                        if (! $ticket->second_notification_sent && $config->second_notification_after > 0
                            && $remaining < 0 && abs($remaining) >= $config->second_notification_after && $managers->isNotEmpty()) {
                            foreach ($managers as $user) {
                                $this->notify->handle($user, "Ticket #{$ticket->id} is ".abs($remaining).' business minutes overdue.',
                                    'Ticket overdue', ['it.tickets.show', $ticket->id]);
                            }
                            $ticket->second_notification_sent = true;
                            $count++;
                        }
                        Ticket::withoutTimestamps(fn () => $ticket->save());

                        return $count;
                    });
                }
            });

        return $sent;
    }
}
