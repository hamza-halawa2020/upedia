<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Notifications\FirebaseAccessTokenService;
use App\Services\Notifications\FirebaseNotificationService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class FirebaseWebDeliveryTest extends TestCase
{
    public function test_web_push_has_one_display_owner_and_preserves_notification_id(): void
    {
        Schema::create('user_device_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('device_token');
            $table->string('token_hash');
            $table->string('project')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->boolean('is_active')->default(true);
        });
        $user = User::create(['full_name' => 'Push tester', 'email' => 'push@example.test', 'password' => bcrypt('test')]);
        DB::table('user_device_tokens')->insert([
            'user_id' => $user->id, 'device_token' => 'test-token', 'token_hash' => hash('sha256', 'test-token'),
        ]);
        config(['services.firebase.project_id' => 'test-project']);
        $this->mock(FirebaseAccessTokenService::class)->shouldReceive('handle')->once()->andReturn('test-access');
        Http::preventStrayRequests();
        Http::fake(['https://fcm.googleapis.com/*' => Http::response(['name' => 'projects/test-project/messages/test'], 200)]);

        app(FirebaseNotificationService::class)->sendToUser($user, [
            'title' => 'Test', 'message' => 'Body', 'notification_id' => 'canonical-id',
            'action_url' => 'https://upedia-all.test/notifications',
        ]);

        Http::assertSentCount(1);
        Http::assertSent(fn ($request) => $request->url() === 'https://fcm.googleapis.com/v1/projects/test-project/messages:send'
            && $request['message']['token'] === 'test-token'
            && $request['message']['data']['notification_id'] === 'canonical-id'
            && $request['message']['data']['body'] === 'Body'
            && $request['message']['webpush']['headers']['Urgency'] === 'high'
            && ! isset($request['message']['notification'])
            && ! isset($request['message']['webpush']['notification']));
    }
}
