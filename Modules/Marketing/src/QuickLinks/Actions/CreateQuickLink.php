<?php

namespace Modules\Marketing\QuickLinks\Actions;

use App\Models\QuickLink;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateQuickLink
{
    public function handle(array $data): QuickLink
    {
        return DB::transaction(function () use ($data) {
            $departmentIds = $data['department_ids'] ?? [];
            unset($data['department_ids']);
            $data['created_by'] = Auth::id();
            $data['is_active'] = (bool) ($data['is_active'] ?? false);
            $quickLink = QuickLink::create($data);
            $quickLink->departments()->sync($departmentIds);

            return $quickLink->load('departments:id,name');
        });
    }
}
