<?php

namespace App\Services\Notifications;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FirebaseAccessTokenService
{
    public function handle(): ?string
    {
        $path = config('services.firebase.service_account_path');

        if (! $path || ! is_file($path)) {
            Log::warning('FirebaseNotificationService.service_account_missing', [
                'path' => $path,
                'exists' => is_file((string) $path),
            ]);

            return null;
        }

        $credentials = json_decode(file_get_contents($path), true);

        if (! is_array($credentials) || empty($credentials['client_email']) || empty($credentials['private_key'])) {
            Log::warning('FirebaseNotificationService.service_account_invalid', [
                'path' => $path,
                'has_client_email' => is_array($credentials) && ! empty($credentials['client_email']),
                'has_private_key' => is_array($credentials) && ! empty($credentials['private_key']),
            ]);

            return null;
        }

        $now = time();
        $header = $this->base64UrlEncode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
        $claim = $this->base64UrlEncode(json_encode([
            'iss' => $credentials['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $now + 3600,
        ]));

        openssl_sign($header.'.'.$claim, $signature, $credentials['private_key'], 'sha256WithRSAEncryption');

        $jwt = $header.'.'.$claim.'.'.$this->base64UrlEncode($signature);

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        if (! $response->successful()) {
            Log::warning('FirebaseNotificationService.access_token_failed', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
        }

        return $response->json('access_token');
    }

    private function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
