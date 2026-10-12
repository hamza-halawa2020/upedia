<?php

namespace Modules\Marketing\QuickLinks\Actions;

use App\Models\QuickLink;

class UpdateQuickLink
{
    public function handle(QuickLink $quickLink, array $data): QuickLink
    {
        $departmentIds = $data['department_ids'] ?? [];
        unset($data['department_ids']);

        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        $quickLink->update($data);
        $quickLink->departments()->sync($departmentIds);

        return $quickLink->load('departments:id,name');
    }
}
