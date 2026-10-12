<?php

namespace Modules\Marketing\QuickLinks\Actions;

use App\Models\QuickLink;

class DeleteQuickLink
{
    public function handle(QuickLink $quickLink): void
    {
        $quickLink->departments()->detach();
        $quickLink->delete();
    }
}
