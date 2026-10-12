<?php

namespace Modules\Marketing\Scripts\Actions;

use App\Models\Script;
use App\Actions\Attachments\DeleteAttachments;

class DeleteScriptAttachments
{
    public function __construct(private readonly DeleteAttachments $attachments) {}
    public function handle(Script $script): void
    {
        $this->attachments->handle($script);
    }
}
