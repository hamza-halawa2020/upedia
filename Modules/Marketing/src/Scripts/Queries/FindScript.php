<?php

namespace Modules\Marketing\Scripts\Queries;

use App\Models\Script;

class FindScript
{
    public function handle(int $scriptId): Script
    {
        return Script::query()
            ->with(['attachments', 'departments:id,name', 'creator', 'approver'])
            ->findOrFail($scriptId);
    }
}

