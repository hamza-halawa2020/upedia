<?php

namespace Modules\Marketing\QuickLinks\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuickLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'link' => ['required', 'url', 'max:255'],
            'department_ids' => ['nullable', 'array'],
            'department_ids.*' => ['exists:sm_human_departments,id'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'link.required' => 'Link is required',
            'link.url' => 'Link must be a valid URL',
        ];
    }
}
