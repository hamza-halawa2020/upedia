<?php

namespace Modules\IT\Purchases\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangePurchaseStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return ['purchase_id' => ['required', 'integer', Rule::exists('purchases', 'id')->where('invoice_type', 'purchase')],
            'status' => ['required', Rule::in(['approved', 'rejected', 'completed', 'purchased'])],
            'expense_head_id' => ['nullable', 'required_if:status,completed', 'integer', 'exists:sm_expense_heads,id']];
    }
}
