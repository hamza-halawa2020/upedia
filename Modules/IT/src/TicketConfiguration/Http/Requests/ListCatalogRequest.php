<?php

namespace Modules\IT\TicketConfiguration\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListCatalogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'per_page' => ['sometimes', 'integer', Rule::in([5, 10, 25, 50, 100, 150])],
            'is_main' => ['nullable', 'boolean'],
            'parent_id' => ['nullable', 'integer', 'exists:ticket_categories,id'],
            'subcategory_id' => ['nullable', 'integer', 'exists:ticket_categories,id'],
        ];
    }
}
