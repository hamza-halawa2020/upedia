<?php

namespace Modules\IT\Tickets\Console;

use Illuminate\Console\Command;
use Modules\IT\Tickets\Actions\SendTicketReminders;

class SendTicketRemindersCommand extends Command
{
    protected $signature = 'it:tickets:send-reminders';

    protected $description = 'Process IT deadline reminders through shared notifications';

    public function handle(SendTicketReminders $reminders): int
    {
        $this->info('Processed '.$reminders->handle().' ticket reminder stages.');

        return self::SUCCESS;
    }
}
