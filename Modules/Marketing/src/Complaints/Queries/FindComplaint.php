<?php

namespace Modules\Marketing\Complaints\Queries;

use App\Models\Complain;

class FindComplaint
{
    public function handle(Complain $complain): Complain
    {
        return $complain->load([
            'staff:id,first_name,last_name',
            'sales:id,first_name,last_name',
            'attachments',
            'solver:id,full_name',
        ]);
    }
}
