<?php

namespace Modules\Marketing\Complaints\Actions;

use App\Models\Complain;
use App\Actions\Attachments\DeleteAttachments;

class DeleteComplaintAttachments
{
    public function __construct(private readonly DeleteAttachments $attachments) {}
    public function handle(Complain $complain): void
    {
        $this->attachments->handle($complain);
    }
}
