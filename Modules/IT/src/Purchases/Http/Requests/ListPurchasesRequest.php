<?php

namespace Modules\IT\Purchases\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListPurchasesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return ['purchase_number' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(['pending', 'approved', 'rejected', 'completed', 'purchased'])],
            'recurring' => ['nullable', 'boolean'], 'staff_id' => ['nullable', 'integer', 'exists:sm_staffs,id'],
            'from_date' => ['nullable', 'date_format:Y-m-d'], 'to_date' => ['nullable', 'date_format:Y-m-d'],
            'per_page' => ['sometimes', 'integer', Rule::in([5, 10, 25, 50, 100, 150])],
            'format' => ['nullable', Rule::in(['xlsx', 'csv', 'pdf'])]];
    }
}
