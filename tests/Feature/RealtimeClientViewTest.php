<?php

namespace Tests\Feature;

use Tests\TestCase;

class RealtimeClientViewTest extends TestCase
{
    public function test_browser_gets_web_configuration_without_private_credentials_or_reverb(): void
    {
        config(['services.firebase.api_key' => 'public-test-key', 'services.firebase.project_id' => 'test-project',
            'services.firebase.service_account_path' => 'backend-only-secret-file']);
        $html = view('notifications::partials.firebase-client')->render();
        $this->assertStringContainsString('public-test-key', $html);
        $this->assertStringContainsString('onMessage', $html);
        $this->assertStringNotContainsString('backend-only-secret-file', $html);
        $this->assertStringNotContainsString('new Pusher', $html);
    }
}
