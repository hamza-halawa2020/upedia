<?php

namespace Modules\IT\Purchases\Actions;

use App\Models\Purchase;
use Modules\IT\Purchases\Exports\PurchasesExport;
use Modules\IT\Purchases\Queries\Purchases;
use Modules\IT\SavedTables\Actions\SaveExportTable;

class SavePurchaseTable
{
    public function __construct(private readonly SaveExportTable $save, private readonly Purchases $query) {}

    public function handle(array $criteria): void
    {
        unset($criteria['format'], $criteria['per_page']);
        $this->save->handle(new PurchasesExport($criteria), 'Purchases', Purchase::class,
            $criteria, $this->query->query($criteria)->count());
    }
}
