<?php

namespace Tests\Feature;

use App\Http\Middleware\SsoTokenAuthenticate;
use App\Models\User;
use App\Notifications\BaseNotification;
use Tests\TestCase;

class BroadcastAuthTest extends TestCase
{
    public function test_users_can_only_authorize_their_own_notification_channel(): void
    {
        config(['broadcasting.default' => 'reverb', 'broadcasting.connections.reverb.key' => 'test-key',
            'broadcasting.connections.reverb.secret' => 'test-secret', 'broadcasting.connections.reverb.app_id' => 'test-app']);
        $this->withoutMiddleware(SsoTokenAuthenticate::class);
        $user = User::create(['full_name' => 'User', 'email' => 'broadcast@example.test', 'password' => bcrypt('test')]);
        $this->actingAs($user)->postJson('/broadcasting/auth', [
            'socket_id' => '123.456', 'channel_name' => 'private-App.Models.User.'.$user->id,
        ])->assertOk()->assertJsonStructure(['auth']);
        $this->postJson('/broadcasting/auth', [
            'socket_id' => '123.456', 'channel_name' => 'private-App.Models.User.'.($user->id + 1),
        ])->assertForbidden();
    }

    public function test_notification_broadcasts_use_the_isolated_queue(): void
    {
        config(['notifications.queue' => 'upedia-all-notifications']);
        $notification = new BaseNotification('Test', 'Title', ['broadcast'], 'http://upedia-all.test/notifications');
        $message = $notification->toBroadcast(new User);
        $this->assertSame('upedia-all-notifications', $message->queue);
        $this->assertSame('Test', $message->data['notification']['message']);
    }
}
