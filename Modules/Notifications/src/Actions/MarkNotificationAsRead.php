<?php

namespace Modules\Notifications\Actions;

use App\Models\User;

class MarkNotificationAsRead
{
    public function handle(User $user, string $notificationId): bool
    {
        $notification = $user->notifications()->find($notificationId);

        if (! $notification) {
            return false;
        }

        $notification->markAsRead();

        return true;
    }
}
