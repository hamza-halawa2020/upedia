<?php

namespace Modules\IT\Expenses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListExpensesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return ['search' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(['paid', 'open', 'pending_approval'])],
            'recurring' => ['nullable', Rule::in(['one_time', 'monthly', 'yearly'])],
            'start_date' => ['nullable', 'date_format:Y-m-d'], 'end_date' => ['nullable', 'date_format:Y-m-d'],
            'per_page' => ['sometimes', 'integer', Rule::in([5, 10, 25, 50, 100, 150])],
            'format' => ['nullable', Rule::in(['xlsx', 'csv'])]];
    }
}
