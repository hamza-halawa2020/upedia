<?php

namespace Modules\Marketing\Complaints\Actions;

use App\Models\Complain;
use App\Actions\Attachments\StoreAttachments;

class StoreComplaintAttachments
{
    public function __construct(private readonly StoreAttachments $attachments) {}

    public function handle(Complain $complain, mixed $files): void
    {
        $this->attachments->handle($complain, $files ?: [], 'complains');
    }
}
