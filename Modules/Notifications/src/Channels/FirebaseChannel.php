<?php

namespace Modules\Notifications\Channels;

use App\Models\User;
use App\Services\Notifications\FirebaseNotificationService;
use Illuminate\Notifications\Notification;

class FirebaseChannel
{
    public function __construct(private readonly FirebaseNotificationService $firebase) {}

    public function send(object $notifiable, Notification $notification): void
    {
        if ($notifiable instanceof User && method_exists($notification, 'toFirebase')) {
            $this->firebase->sendToUser($notifiable, $notification->toFirebase($notifiable));
        }
    }
}
