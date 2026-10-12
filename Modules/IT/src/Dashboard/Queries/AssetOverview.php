<?php

namespace Modules\IT\Dashboard\Queries;

use Illuminate\Support\Facades\DB;

class AssetOverview
{
    public function handle(): array
    {
        $counts = "COUNT(*) as total, SUM(CASE WHEN is_currently_in_use = 'in_use' THEN 1 ELSE 0 END) as in_use,
            SUM(CASE WHEN is_currently_in_use = 'in_store' THEN 1 ELSE 0 END) as in_store,
            SUM(CASE WHEN is_currently_in_use = 'in_repair' THEN 1 ELSE 0 END) as in_repair";

        return ['summary' => DB::table('assets')->selectRaw($counts)->first(),
            'groups' => DB::table('assets')->select('name')->selectRaw($counts)->groupBy('name')->orderBy('name')->get()];
    }
}
