<?php

namespace Modules\Marketing\Scripts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class ScriptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_name' => ['required', 'string', 'max:255'],
            'visibility' => ['required', 'in:public,private'],
            'status' => ['nullable', 'string', 'max:50'],
            'department_ids' => ['nullable', 'array'],
            'department_ids.*' => ['exists:sm_human_departments,id'],
            'keywords' => ['nullable', 'string', 'max:255'],
            'attachments' => ['nullable', 'array', 'max:5'],
            'attachments.*' => ['file', 'mimes:pdf,jpg,png', 'max:5120'],
        ];
    }

    public function payload(): array
    {
        return Arr::except($this->validated(), ['attachments']);
    }
}

