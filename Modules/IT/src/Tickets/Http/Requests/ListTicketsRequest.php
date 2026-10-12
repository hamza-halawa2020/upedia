<?php

namespace Modules\IT\Tickets\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListTicketsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return ['search' => ['nullable', 'string', 'max:255'], 'q' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(['open', 'closed', 'pending', 'in_progress'])],
            'assigned_to' => ['nullable', 'integer', 'exists:sm_staffs,id'],
            'requester_id' => ['nullable', 'integer', 'exists:sm_staffs,id'],
            'ticket_priority_id' => ['nullable', 'integer', 'exists:ticket_priorities,id'],
            'start_date' => ['nullable', 'date_format:Y-m-d'], 'end_date' => ['nullable', 'date_format:Y-m-d'],
            'per_page' => ['sometimes', 'integer', Rule::in([5, 10, 25, 50, 100, 150])],
            'format' => ['nullable', Rule::in(['xlsx', 'csv'])]];
    }
}
