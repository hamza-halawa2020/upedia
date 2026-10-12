<?php

namespace Modules\IT\Tickets\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return ['title' => ['required', 'string', 'max:255'], 'description' => ['required', 'string'],
            'resolution_description' => ['nullable', 'required_if:status,closed', 'string'],
            'ticket_category_id' => ['required', 'integer', Rule::exists('ticket_categories', 'id')->whereNull('parent_id')],
            'ticket_subcategory_id' => ['nullable', 'integer', Rule::exists('ticket_categories', 'id')->where('parent_id', $this->input('ticket_category_id'))],
            'ticket_item_id' => ['nullable', 'integer', Rule::exists('ticket_items', 'id')->where('ticket_subcategory_id', $this->input('ticket_subcategory_id') ?? -1)],
            'request_type' => ['nullable', Rule::in(['issue', 'request', 'inquiry'])],
            'ticket_priority_id' => ['required', 'integer', 'exists:ticket_priorities,id'],
            'requester_id' => ['required', 'integer', 'exists:sm_staffs,id'],
            'assigned_to' => ['nullable', 'integer', 'exists:sm_staffs,id'],
            'status' => ['required', Rule::in(['open', 'closed', 'pending', 'in_progress'])],
            'attachments' => ['nullable', 'array', 'max:5'],
            'attachments.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120']];
    }
}
