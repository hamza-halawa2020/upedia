<?php

namespace Modules\IT\Solutions\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveSolutionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'topic_name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'keywords' => ['nullable', 'string'],
            'visibility' => ['required', Rule::in(['all', 'it_only', 'departments'])],
            'department_ids' => ['required_if:visibility,departments', 'array'],
            'attachments' => ['nullable', 'array', 'max:5'],
            'attachments.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'department_ids.*' => ['integer', 'distinct', 'exists:sm_human_departments,id'],
        ];
    }
}
