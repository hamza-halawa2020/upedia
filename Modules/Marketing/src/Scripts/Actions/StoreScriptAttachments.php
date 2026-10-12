<?php

namespace Modules\Marketing\Scripts\Actions;

use App\Models\Script;

class StoreScriptAttachments
{
    public function handle(Script $script, mixed $files): void
    {
        if (! $files || count($files) === 0) {
            return;
        }

        foreach ($files as $file) {
            if (! $file->isValid()) {
                continue;
            }

            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/scripts'), $filename);

            $script->attachments()->create(['file_path' => 'uploads/scripts/'.$filename]);
        }
    }
}

