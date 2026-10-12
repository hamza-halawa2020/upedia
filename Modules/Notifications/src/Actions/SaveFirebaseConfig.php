<?php

namespace Modules\Notifications\Actions;

use App\Models\FirebaseNotificationConfig;

class SaveFirebaseConfig
{
    public function handle(array $data): void
    {
        FirebaseNotificationConfig::updateOrCreate(['id' => 1], $data);
    }
}
