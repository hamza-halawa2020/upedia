<?php

namespace Modules\Marketing\Scripts\Actions;

use App\Models\Script;
use App\Models\User;

class AuthorizeScriptAccess
{
    public function handle(User $user, Script $script, string $action): void
    {
        $staff = $user->staff()->with(['jobTitle:id,slug'])->first();

        if ($user->hasRole('Super admin') || $staff?->jobTitle?->slug === 'marketing_manager') {
            return;
        }

        if ($script->created_by === $user->id) {
            return;
        }

        if ($action === 'view' && $staff && $script->status === 'approved' && $script->departments->contains($staff->department_id)) {
            return;
        }

        abort(403, 'Unauthorized - You are not allowed to '.$action.' this script.');
    }
}

