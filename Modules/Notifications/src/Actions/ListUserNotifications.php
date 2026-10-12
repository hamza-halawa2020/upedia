<?php

namespace Modules\Notifications\Actions;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListUserNotifications
{
    public function handle(User $user, int $perPage = 20): LengthAwarePaginator
    {
        return $user->notifications()->paginate($perPage);
    }
}
