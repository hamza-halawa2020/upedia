<?php

namespace Modules\IT\Expenses\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\IT\Expenses\Models\ItExpense;

class DeleteExpense
{
    public function handle(int $id): void
    {
        DB::transaction(function () use ($id) {
            $expense = ItExpense::lockForUpdate()->findOrFail($id);
            if ($expense->status === 'paid') {
                throw ValidationException::withMessages(['expense' => 'Paid expenses cannot be deleted.']);
            }
            $expense->delete();
        });
    }
}
