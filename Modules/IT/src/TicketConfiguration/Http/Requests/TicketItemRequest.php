<?php

namespace Modules\IT\TicketConfiguration\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TicketItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('ticket_items', 'name')->ignore($this->route('record'))],
            'ticket_subcategory_id' => ['required', 'integer', Rule::exists('ticket_categories', 'id')->whereNotNull('parent_id')],
        ];
    }
}
