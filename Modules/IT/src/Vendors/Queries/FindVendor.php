<?php

namespace Modules\IT\Vendors\Queries;

use App\Models\Vendor;

class FindVendor
{
    public function handle(int $id): Vendor
    {
        return Vendor::findOrFail($id);
    }
}
