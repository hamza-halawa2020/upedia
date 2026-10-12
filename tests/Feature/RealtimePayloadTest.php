<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\BaseNotification;
use App\Services\Notifications\FirebaseNotificationService;
use Tests\TestCase;

class RealtimePayloadTest extends TestCase
{
    public function test_database_and_broadcast_share_a_deduplication_id_without_forcing_push(): void
    {
        $this->mock(FirebaseNotificationService::class)->shouldNotReceive('sendToUser');
        $notification = new BaseNotification('Message', 'Title', ['database', 'broadcast'], 'http://upedia-all.test/notifications');
        $notification->id = 'fixed-notification-id';
        $notification->sendPush = false;
        $database = $notification->toDatabase(new User);
        $broadcast = $notification->toBroadcast(new User)->data;
        $this->assertSame('fixed-notification-id', $database['notification_id']);
        $this->assertSame($database['notification_id'], $broadcast['notification']['notification_id']);
        $this->assertSame($database['message'], $broadcast['notification']['message']);
    }
}
