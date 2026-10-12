<?php

namespace Modules\Marketing\QuickLinks\Actions;

use App\Models\QuickLink;
use Illuminate\Support\Facades\DB;

class DeleteQuickLink
{
    public function handle(QuickLink $quickLink): void
    {
        DB::transaction(function () use ($quickLink) {
            $quickLink = QuickLink::query()->lockForUpdate()->findOrFail($quickLink->id);
            $quickLink->departments()->detach();
            $quickLink->delete();
        });
    }
}
