<?php

namespace Modules\Marketing\Scripts\Actions;

use App\Models\Script;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateScript
{
    public function __construct(
        private readonly StoreScriptAttachments $storeAttachments,
        private readonly DeleteScriptAttachments $deleteAttachments,
    ) {
    }

    public function handle(User $user, int $scriptId, array $data, mixed $files = null): Script
    {
        return DB::transaction(function () use ($user, $scriptId, $data, $files) {
            $script = Script::with('attachments')->findOrFail($scriptId);
            $departmentIds = ($data['visibility'] ?? null) === 'private' ? [] : ($data['department_ids'] ?? []);

            unset($data['department_ids']);

            if (($data['status'] ?? null) === 'approved') {
                $data['approved_by'] = $user->id;
            }

            $script->update($data);
            $script->departments()->sync($departmentIds);

            if ($files !== null) {
                $this->deleteAttachments->handle($script);
                $this->storeAttachments->handle($script, $files);
            }

            return $script;
        });
    }
}

