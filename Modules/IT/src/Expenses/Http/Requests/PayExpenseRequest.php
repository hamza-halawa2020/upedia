<?php

namespace Modules\IT\Expenses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return ['expense_id' => ['required', 'integer', 'exists:expenses,id'],
            'expense_head_id' => ['required', 'integer', 'exists:sm_expense_heads,id']];
    }
}
