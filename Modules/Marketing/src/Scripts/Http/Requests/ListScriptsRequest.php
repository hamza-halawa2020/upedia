<?php

namespace Modules\Marketing\Scripts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListScriptsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'category_name' => ['nullable', 'string', 'max:255'],
            'visibility' => ['nullable', 'in:public,private'],
            'status' => ['nullable', 'string', 'max:50'],
            'department_id' => ['nullable', 'integer', 'exists:sm_human_departments,id'],
            'per_page' => ['nullable', 'integer', 'in:5,10,25,50,100,150'],
        ];
    }

    public function criteria(): array
    {
        return $this->validated();
    }
}

