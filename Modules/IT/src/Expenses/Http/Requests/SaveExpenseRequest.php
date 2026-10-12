<?php

namespace Modules\IT\Expenses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveExpenseRequest extends FormRequest
{
    public function authorize(): bool { return $this->user() !== null; }
    public function rules(): array
    {
        return ['amount' => ['required', 'numeric', 'min:0'], 'payment_date' => ['required', 'date_format:Y-m-d'],
            'due_date' => ['nullable', 'date_format:Y-m-d'], 'item_name' => ['required', 'string', 'max:255'],
            'vendors' => ['required', 'string'], 'payment_method' => ['required', Rule::in(['petty_cash', 'finance_team'])],
            'recurring' => ['required', Rule::in(['one_time', 'monthly', 'yearly'])],
            'expense_head_id' => ['nullable', 'required_if:payment_method,petty_cash', 'integer', 'exists:sm_expense_heads,id'],
            'status' => ['prohibited']];
    }
}
