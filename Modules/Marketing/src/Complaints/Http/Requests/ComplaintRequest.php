<?php

namespace Modules\Marketing\Complaints\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComplaintRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'platform' => ['required', 'in:facebook,tiktok,youtube,X,snapchat,instagram'],
            'staff_id' => ['required', 'exists:sm_staffs,id'],
            'system' => ['required', 'string', 'max:255'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'client_number' => ['required', 'string', 'max:30', 'regex:/^[0-9+\-\s()]+$/'],
            'department' => ['required', 'in:sales,retention'],
            'case_type' => ['required', 'in:complaint,follow_up'],
            'note' => ['nullable', 'string'],
            'moderator_note' => ['nullable', 'string'],
            'inside_outside' => ['required', 'in:inside,outside'],
            'status' => ['nullable', 'in:solved,not_solved'],
            'priority' => ['required', 'in:low,medium,high'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:5120', 'mimes:jpg,jpeg,png,pdf,doc,docx'],
            'date' => $this->dateRules(),
        ];
    }

    private function dateRules(): array
    {
        if ($this->isMethod('post')) {
            return ['required', 'date', 'after_or_equal:today'];
        }

        return [
            'required',
            'date',
            function (string $attribute, mixed $value, \Closure $fail): void {
                $complain = $this->route('complain');

                if ($complain && $value !== $complain->date && $value < date('Y-m-d')) {
                    $fail('The date must be today or a future date.');
                }
            },
        ];
    }
}
