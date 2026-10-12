<?php

namespace Modules\IT\Products\Queries;

use App\Models\ItProduct;

class FindProduct
{
    public function handle(int $id): ItProduct
    {
        return ItProduct::findOrFail($id);
    }
}
