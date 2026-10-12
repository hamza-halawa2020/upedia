<?php

namespace Modules\IT\TicketConfiguration\Actions;

use Illuminate\Support\Facades\DB;
use Modules\IT\TicketConfiguration\Catalog;

class DeleteCatalogRecord
{
    public function handle(Catalog $catalog, int $id): void
    {
        DB::transaction(fn () => $catalog->model()::lockForUpdate()->findOrFail($id)->delete());
    }
}
