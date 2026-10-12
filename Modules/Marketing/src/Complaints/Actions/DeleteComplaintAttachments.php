<?php

namespace Modules\Marketing\Complaints\Actions;

use App\Models\Complain;

class DeleteComplaintAttachments
{
    public function handle(Complain $complain): void
    {
        $complain->loadMissing('attachments');

        foreach ($complain->attachments as $attachment) {
            $filePath = public_path($attachment->file_path);

            if (is_file($filePath)) {
                unlink($filePath);
            }

            $attachment->delete();
        }
    }
}
