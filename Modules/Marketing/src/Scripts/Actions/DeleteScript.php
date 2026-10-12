<?php

namespace Modules\Marketing\Scripts\Actions;

use App\Models\Script;
use Illuminate\Support\Facades\DB;

class DeleteScript
{
    public function __construct(private readonly DeleteScriptAttachments $deleteAttachments)
    {
    }

    public function handle(int $scriptId): void
    {
        DB::transaction(function () use ($scriptId): void {
            $script = Script::with('attachments')->findOrFail($scriptId);
            $this->deleteAttachments->handle($script);
            $script->delete();
        });
    }
}

