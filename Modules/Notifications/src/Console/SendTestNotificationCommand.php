<?php

namespace Modules\Notifications\Console;

use App\Models\User;
use App\Notifications\BaseNotification;
use Illuminate\Console\Command;

class SendTestNotificationCommand extends Command
{
    protected $signature = 'notifications:send-test {email} {--firebase : Send Firebase push as well as saving the notification}';
    protected $description = 'Send a local database notification, optionally through Firebase';

    public function handle(): int
    {
        if (! app()->environment(['local', 'testing'])) {
            $this->error('This command is restricted to local/test environments.');
            return self::FAILURE;
        }
        $user = User::where('email', $this->argument('email'))->firstOrFail();
        $push = (bool) $this->option('firebase');
        if ($push && ! $user->deviceTokens()->where('is_active', true)->where('device_type', 'web')->exists()) {
            $this->error('No active web token for this user. Open the HTTPS site and enable browser notifications first.');
            return self::FAILURE;
        }
        $notification = new BaseNotification('Firebase notification connection test.', 'Upedia Firebase test',
            ['database'], ['notifications.index']);
        $notification->sendPush = $push;
        $user->notify($notification);
        $this->info($push ? 'Notification saved and Firebase delivery requested; browser receipt still needs confirmation.'
            : 'Notification saved only. Use --firebase to test push.');
        return self::SUCCESS;
    }
}
