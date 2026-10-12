<?php

namespace Modules\Notifications\Actions;

use App\Models\User;
use App\Notifications\BaseNotification;
use Illuminate\Support\Facades\DB;

class NotifyActor
{
    public function handle(?User $actor, string $message, string $title, array $route): void
    {
        if ($actor === null) {
            return;
        }

        DB::afterCommit(fn () => $actor->notify(
            new BaseNotification($message, $title, ['database'], $route)
        ));
    }
}
