<?php

namespace Modules\Marketing\Complaints\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckLeadPhoneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_number' => ['required', 'string', 'max:30'],
        ];
    }
}
