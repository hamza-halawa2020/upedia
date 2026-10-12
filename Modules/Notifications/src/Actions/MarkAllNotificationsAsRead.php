<?php

namespace Modules\Notifications\Actions;

use App\Models\User;

class MarkAllNotificationsAsRead
{
    public function handle(User $user): void
    {
        $user->unreadNotifications->each->markAsRead();
    }
}
