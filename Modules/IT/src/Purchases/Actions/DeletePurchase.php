<?php

namespace Modules\IT\Purchases\Actions;

use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DeletePurchase
{
    public function handle(int $id): void
    {
        DB::transaction(function () use ($id) {
            $purchase = Purchase::where('invoice_type', 'purchase')->lockForUpdate()->findOrFail($id);
            if ($purchase->status !== 'pending' || $purchase->attachments()->exists()
                || $purchase->purchaseInvoices()->exists()) {
                throw ValidationException::withMessages(['purchase' => 'Only pending, unattached and uninvoiced purchases can be deleted.']);
            }
            $purchase->details()->delete();
            $purchase->requestedStaffs()->detach();
            $purchase->vendors()->detach();
            $purchase->delete();
        });
    }
}
