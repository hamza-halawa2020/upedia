<?php

namespace Modules\Notifications\Queries;

use App\Models\FirebaseNotificationConfig;

class FirebaseConfig
{
    public function handle(): ?FirebaseNotificationConfig
    {
        return FirebaseNotificationConfig::find(1);
    }
}
