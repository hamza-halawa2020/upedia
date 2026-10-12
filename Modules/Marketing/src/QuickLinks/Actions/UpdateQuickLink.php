<?php

namespace Modules\Marketing\QuickLinks\Actions;

use App\Models\QuickLink;
use Illuminate\Support\Facades\DB;

class UpdateQuickLink
{
    public function handle(QuickLink $quickLink, array $data): QuickLink
    {
        return DB::transaction(function () use ($quickLink, $data) {
            $quickLink = QuickLink::query()->lockForUpdate()->findOrFail($quickLink->id);
            $departmentIds = $data['department_ids'] ?? [];
            unset($data['department_ids']);
            $data['is_active'] = (bool) ($data['is_active'] ?? false);
            $quickLink->update($data);
            $quickLink->departments()->sync($departmentIds);

            return $quickLink->load('departments:id,name');
        });
    }
}
