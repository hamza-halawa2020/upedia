<?php

namespace App\Services\Notifications;

use App\Models\User;
use App\Models\UserDeviceToken;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FirebaseNotificationService
{
    public function sendToUser(User $user, array $payload): void
    {
        $deviceTokens = UserDeviceToken::query()
            ->where('user_id', $user->id)
            ->where('is_active', true)
            ->get(['device_token', 'token_hash', 'project', 'last_used_at'])
            ->filter(fn (UserDeviceToken $deviceToken) => filled($deviceToken->device_token))
            ->unique('device_token')
            ->values();

        if ($deviceTokens->isEmpty()) {
            return;
        }

        $deviceTokens->each(fn (UserDeviceToken $deviceToken) => $this->sendToToken($deviceToken->device_token, $payload));
    }

    private function sendToToken(string $token, array $payload): void
    {
        try {
            if ($accessToken = $this->accessToken()) {
                $this->sendViaHttpV1($token, $payload, $accessToken);

                return;
            }

            if ($serverKey = config('services.firebase.server_key')) {
                $this->sendViaLegacyApi($token, $payload, $serverKey);
            }

            if (! config('services.firebase.server_key')) {
                Log::warning('FirebaseNotificationService.no_credentials', [
                    'token_hash' => $this->shortTokenHash($token),
                    'service_account_path' => config('services.firebase.service_account_path'),
                    'service_account_exists' => is_file((string) config('services.firebase.service_account_path')),
                    'has_server_key' => false,
                ]);
            }
        } catch (\Throwable $exception) {
            Log::warning('Firebase notification failed', [
                'message' => $exception->getMessage(),
                'token_hash' => $this->shortTokenHash($token),
            ]);
        }
    }

    private function sendViaHttpV1(string $token, array $payload, string $accessToken): void
    {
        $projectId = config('services.firebase.project_id');

        if (! $projectId) {
            return;
        }

        $response = Http::withToken($accessToken)
            ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                'message' => [
                    'token' => $token,
                    'data' => $this->firebaseData($payload),
                    'webpush' => [
                        'notification' => [
                            'title' => $payload['title'] ?? 'Notification',
                            'body' => $payload['message'] ?? '',
                            'icon' => '/assets/images/logo-icon.png',
                            'badge' => '/assets/images/logo-icon.png',
                            'tag' => $this->notificationTag($payload),
                            'renotify' => true,
                            'data' => $this->firebaseData($payload),
                        ],
                        'fcm_options' => [
                            'link' => $payload['action_url'] ?? url('/notifications'),
                        ],
                    ],
                ],
            ]);

        if (! $response->successful()) {
            Log::warning('FirebaseNotificationService.http_v1_failed', [
                'token_hash' => $this->shortTokenHash($token),
                'project_id' => $projectId,
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
        }

        if ($this->isUnregisteredTokenResponse($response->body())) {
            $this->deactivateToken($token, 'http_v1_unregistered');
        }
    }

    private function sendViaLegacyApi(string $token, array $payload, string $serverKey): void
    {
        $response = Http::withHeaders([
            'Authorization' => 'key='.$serverKey,
            'Content-Type' => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', [
            'to' => $token,
            'data' => $this->firebaseData($payload),
            'notification' => [
                'title' => $payload['title'] ?? 'Notification',
                'body' => $payload['message'] ?? '',
                'icon' => '/assets/images/logo-icon.png',
                'tag' => $this->notificationTag($payload),
            ],
        ]);

        if (! $response->successful()) {
            Log::warning('FirebaseNotificationService.legacy_failed', [
                'token_hash' => $this->shortTokenHash($token),
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
        }

        if ($this->isUnregisteredTokenResponse($response->body())) {
            $this->deactivateToken($token, 'legacy_unregistered');
        }
    }

    private function accessToken(): ?string
    {
        return app(FirebaseAccessTokenService::class)->handle();
    }

    private function stringData(array $payload): array
    {
        return collect($payload)
            ->map(fn ($value) => is_scalar($value) || $value === null ? (string) $value : json_encode($value))
            ->all();
    }

    private function firebaseData(array $payload): array
    {
        $notificationId = $payload['notification_id'] ?? (string) str()->uuid();

        return $this->stringData(array_merge($payload, [
            'title' => $payload['title'] ?? 'Notification',
            'message' => $payload['message'] ?? '',
            'body' => $payload['message'] ?? '',
            'notification_title' => $payload['title'] ?? 'Notification',
            'notification_body' => $payload['message'] ?? '',
            'action_url' => $payload['action_url'] ?? url('/notifications'),
            'notification_id' => $notificationId,
        ]));
    }

    private function notificationTag(array $payload): string
    {
        return md5(($payload['action_url'] ?? url('/notifications')).'|'.($payload['title'] ?? 'Notification').'|'.($payload['message'] ?? '').'|'.now()->timestamp);
    }

    private function shortTokenHash(string $token): string
    {
        return substr(hash('sha256', $token), 0, 16);
    }

    private function isUnregisteredTokenResponse(?string $body): bool
    {
        return is_string($body)
            && (str_contains($body, 'UNREGISTERED') || str_contains($body, 'NotRegistered'));
    }

    private function deactivateToken(string $token, string $reason): void
    {
        $tokenHash = hash('sha256', $token);

        $updated = UserDeviceToken::query()
            ->where('token_hash', $tokenHash)
            ->update(['is_active' => false]);

        Log::warning('FirebaseNotificationService.token_deactivated', [
            'token_hash' => substr($tokenHash, 0, 16),
            'reason' => $reason,
            'updated_rows' => $updated,
        ]);
    }
}
