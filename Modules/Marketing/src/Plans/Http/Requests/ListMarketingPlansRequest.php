<?php

namespace Modules\Marketing\Plans\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListMarketingPlansRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'platform' => ['nullable', 'string', 'max:50'],
            'status' => ['nullable', 'string', 'max:50'],
            'type' => ['nullable', 'string', 'max:50'],
            'created_by' => ['nullable', 'integer'],
            'month' => ['nullable', 'string', 'max:20'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'per_page' => ['nullable', 'integer', 'in:5,10,25,50,100,150'],
        ];
    }

    public function criteria(): array
    {
        return $this->validated();
    }
}

