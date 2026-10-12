<?php

namespace Modules\Notifications\Actions;

use App\Models\User;
use App\Models\UserDeviceToken;
use Illuminate\Http\Request;

class StoreDeviceToken
{
    public function handle(User $user, array $data, Request $request): UserDeviceToken
    {
        $tokenHash = hash('sha256', $data['device_token']);

        return UserDeviceToken::query()->updateOrCreate(
            [
                'user_id' => $user->id,
                'token_hash' => $tokenHash,
            ],
            [
                'device_token' => $data['device_token'],
                'device_type' => $data['device_type'] ?? 'web',
                'device_name' => $data['device_name'] ?? $request->userAgent(),
                'project' => $data['project'] ?? 'settings',
                'is_active' => true,
                'last_used_at' => now(),
            ]
        );
    }
}
