<?php

namespace Modules\IT\Expenses\Actions;

use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\IT\Expenses\Models\ItExpense;

class PayExpense
{
    public function handle(int $id, int $headId, int $actorId): void
    {
        DB::transaction(function () use ($id, $headId, $actorId) {
            $expense = ItExpense::lockForUpdate()->findOrFail($id);
            if ($expense->status !== 'pending_approval' || $expense->payment_method !== 'finance_team') {
                throw ValidationException::withMessages(['expense_id' => 'Only pending finance-team expenses can be paid.']);
            }
            Expense::create(['name' => $expense->item_name, 'date' => $expense->created_at->toDateString(),
                'amount' => $expense->amount, 'expense_head_id' => $headId, 'created_by' => $actorId]);
            $expense->update(['status' => 'paid', 'expense_head_id' => $headId]);
        });
    }
}
