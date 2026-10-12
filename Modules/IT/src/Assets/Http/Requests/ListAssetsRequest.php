<?php

namespace Modules\IT\Assets\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListAssetsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return ['search' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(['in_use', 'in_store', 'in_repair'])],
            'start_date' => ['nullable', 'date_format:Y-m-d'], 'end_date' => ['nullable', 'date_format:Y-m-d'],
            'per_page' => ['sometimes', 'integer', Rule::in([5, 10, 15, 25, 50, 100, 150])],
            'format' => ['nullable', Rule::in(['xlsx', 'csv', 'pdf'])]];
    }
}
