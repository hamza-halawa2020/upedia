<?php

namespace Modules\Notifications\Console;

use App\Models\User;
use App\Notifications\BaseNotification;
use Illuminate\Console\Command;

class SendTestNotificationCommand extends Command
{
    protected $signature = 'notifications:send-test {email} {--firebase : Also request Firebase push delivery}';

    protected $description = 'Send a single local test notification through database and broadcast channels';

    public function handle(): int
    {
        if (! app()->environment(['local', 'testing'])) {
            $this->error('This command is restricted to local/test environments.');

            return self::FAILURE;
        }
        $user = User::where('email', $this->argument('email'))->firstOrFail();
        $notification = new BaseNotification('Realtime connection test completed.', 'Upedia notification test',
            ['database', 'broadcast'], ['notifications.index']);
        $notification->sendPush = (bool) $this->option('firebase');
        $user->notify($notification);
        $this->info('Test notification stored; broadcast queued on '.config('notifications.queue').'.');
        if ($notification->sendPush) {
            $this->warn('Firebase was requested; delivery still requires a valid browser device token.');
        }

        return self::SUCCESS;
    }
}
