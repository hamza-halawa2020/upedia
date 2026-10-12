<?php

namespace Modules\Marketing\Scripts\Actions;

use App\Models\Script;

class DeleteScriptAttachments
{
    public function handle(Script $script): void
    {
        foreach ($script->attachments as $attachment) {
            $filePath = public_path($attachment->file_path);

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $attachment->delete();
        }
    }
}

