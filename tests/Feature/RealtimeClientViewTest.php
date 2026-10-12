<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class RealtimeClientViewTest extends TestCase
{
    public function test_browser_receives_public_key_and_own_channel_but_not_app_secret(): void
    {
        config(['broadcasting.default' => 'reverb', 'broadcasting.connections.reverb.key' => 'public-test-key',
            'broadcasting.connections.reverb.secret' => 'backend-only-secret',
            'broadcasting.connections.reverb.options.host' => 'upedia-all.test',
            'broadcasting.connections.reverb.options.port' => 8080,
            'broadcasting.connections.reverb.options.scheme' => 'https']);
        $this->actingAs((new User)->forceFill(['id' => 123]));
        $html = view('notifications::partials.reverb-client')->render();
        $this->assertStringContainsString('public-test-key', $html);
        $this->assertStringContainsString('private-App.Models.User.123', $html);
        $this->assertStringContainsString('/broadcasting/auth', $html);
        $this->assertStringNotContainsString('backend-only-secret', $html);
    }
}
