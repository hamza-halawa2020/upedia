<?php

namespace Modules\IT\Expenses\Actions;

use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\IT\Expenses\Models\ItExpense;

class SaveExpense
{
    public function handle(array $data, int $actorId, ?int $id = null): ItExpense
    {
        return DB::transaction(function () use ($data, $actorId, $id) {
            $expense = $id ? ItExpense::lockForUpdate()->findOrFail($id) : new ItExpense;
            if ($id && $expense->status === 'paid') {
                throw ValidationException::withMessages(['expense' => 'Paid expenses cannot be edited.']);
            }
            $expense->fill($data);
            $expense->status = $data['payment_method'] === 'petty_cash' ? 'paid' : 'pending_approval';
            $expense->save();
            if ($expense->status === 'paid') {
                Expense::create(['name' => $expense->item_name, 'date' => $expense->created_at->toDateString(),
                    'amount' => $expense->amount, 'expense_head_id' => $expense->expense_head_id, 'created_by' => $actorId]);
            }

            return $expense;
        });
    }
}
