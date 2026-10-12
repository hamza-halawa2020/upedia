<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\BaseNotification;
use App\Services\Notifications\FirebaseNotificationService;
use Modules\Notifications\Channels\FirebaseChannel;
use Tests\TestCase;

class RealtimePayloadTest extends TestCase
{
    public function test_firebase_replaces_legacy_broadcast_and_shares_database_id(): void
    {
        $notification = new BaseNotification('Message', 'Title', ['database', 'broadcast'], 'http://upedia-all.test/notifications');
        $notification->id = 'fixed-notification-id';
        $user = new User;
        $this->assertSame(['database', FirebaseChannel::class], $notification->via($user));
        $this->assertSame($notification->toDatabase($user), $notification->toFirebase($user));
        $this->assertSame('fixed-notification-id', $notification->toFirebase($user)['notification_id']);
        $notification->sendPush = false;
        $this->assertSame(['database'], $notification->via($user));
    }

    public function test_firebase_channel_calls_shared_sender_once_and_database_mapping_has_no_network_side_effect(): void
    {
        $user = new User;
        $notification = new BaseNotification('Message', 'Title', ['database'], 'http://upedia-all.test/notifications');
        $notification->id = 'test-id';
        $sender = $this->mock(FirebaseNotificationService::class);
        $sender->shouldReceive('sendToUser')->once()->with($user, $notification->toFirebase($user));
        $this->assertSame('test-id', $notification->toDatabase($user)['notification_id']);
        app(FirebaseChannel::class)->send($user, $notification);
    }
}
