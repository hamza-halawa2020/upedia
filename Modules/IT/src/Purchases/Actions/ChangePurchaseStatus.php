<?php

namespace Modules\IT\Purchases\Actions;

use App\Models\Expense;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ChangePurchaseStatus
{
    public function handle(int $id, string $status, ?int $headId, int $actorId): void
    {
        DB::transaction(function () use ($id, $status, $headId, $actorId) {
            $purchase = Purchase::where('invoice_type', 'purchase')->lockForUpdate()->findOrFail($id);
            $transitions = ['pending' => ['approved', 'rejected'], 'approved' => ['completed', 'rejected', 'purchased']];
            if (! in_array($status, $transitions[$purchase->status] ?? [], true)) {
                throw ValidationException::withMessages(['status' => 'Invalid purchase status transition.']);
            }
            if ($status === 'completed') {
                if (! $headId) {
                    throw ValidationException::withMessages(['expense_head_id' => 'Expense head is required.']);
                }
                Expense::create(['name' => $purchase->name, 'date' => $purchase->created_at->toDateString(),
                    'amount' => $purchase->total, 'expense_head_id' => $headId, 'created_by' => $actorId]);
            }
            $purchase->update(['status' => $status]);
        });
    }
}
