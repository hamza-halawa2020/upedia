<?php

namespace Modules\Marketing\Complaints\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListComplaintsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'platform' => ['nullable', 'in:facebook,tiktok,youtube,X,snapchat,instagram'],
            'staff_id' => ['nullable', 'integer', 'exists:sm_staffs,id'],
            'priority' => ['nullable', 'in:low,medium,high'],
            'status' => ['nullable', 'in:solved,not_solved'],
            'inside_outside' => ['nullable', 'in:inside,outside'],
            'department' => ['nullable', 'in:sales,retention'],
            'case_type' => ['nullable', 'in:complaint,follow_up'],
            'creator_id' => ['nullable', 'integer', 'exists:sm_staffs,id'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'per_page' => ['nullable', 'integer', 'in:5,10,25,50,100,150'],
        ];
    }
}
