<?php

namespace Modules\IT\Solutions\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrowseSolutionsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return ['search' => ['nullable', 'string', 'max:255'],
            'sort' => ['nullable', Rule::in(['latest', 'popular', 'az'])]];
    }
}
