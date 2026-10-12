<?php

namespace Modules\Marketing\Scripts\Actions;

use App\Models\Script;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateScript
{
    public function __construct(private readonly StoreScriptAttachments $attachments)
    {
    }

    public function handle(User $user, array $data, mixed $files = null): Script
    {
        return DB::transaction(function () use ($user, $data, $files) {
            $departmentIds = $this->departmentIds($data);
            $data = $this->prepareData($user, $data);
            $script = Script::create($data);

            $script->departments()->sync($departmentIds);
            $this->attachments->handle($script, $files);

            return $script;
        });
    }

    private function departmentIds(array $data): array
    {
        return ($data['visibility'] ?? null) === 'private' ? [] : ($data['department_ids'] ?? []);
    }

    private function prepareData(User $user, array $data): array
    {
        unset($data['department_ids']);
        $data['created_by'] = $user->id;

        if ($user->staff?->jobTitle?->slug === 'marketing_manager') {
            $data['status'] = 'approved';
            $data['approved_by'] = $user->id;
        }

        return $data;
    }
}

