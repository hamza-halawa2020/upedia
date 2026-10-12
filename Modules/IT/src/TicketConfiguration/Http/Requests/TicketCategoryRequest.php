<?php

namespace Modules\IT\TicketConfiguration\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TicketCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'priority_id' => ['nullable', 'integer', 'exists:ticket_priorities,id'],
            'parent_id' => ['nullable', 'integer', Rule::exists('ticket_categories', 'id')->whereNull('parent_id'), Rule::notIn([(int) $this->route('record')])],
        ];
    }
}
