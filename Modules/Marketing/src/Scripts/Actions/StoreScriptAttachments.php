<?php

namespace Modules\Marketing\Scripts\Actions;

use App\Models\Script;
use App\Actions\Attachments\StoreAttachments;

class StoreScriptAttachments
{
    public function __construct(private readonly StoreAttachments $attachments) {}

    public function handle(Script $script, mixed $files): void
    {
        $this->attachments->handle($script, $files ?: [], 'scripts');
    }
}
