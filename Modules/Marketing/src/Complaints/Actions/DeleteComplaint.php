<?php

namespace Modules\Marketing\Complaints\Actions;

use App\Models\Complain;

class DeleteComplaint
{
    public function __construct(private readonly DeleteComplaintAttachments $deleteAttachments)
    {
    }

    public function handle(Complain $complain): void
    {
        $this->deleteAttachments->handle($complain);
        $complain->delete();
    }
}
