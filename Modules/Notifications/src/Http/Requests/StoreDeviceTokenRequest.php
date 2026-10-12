<?php

namespace Modules\Notifications\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceTokenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'device_token' => ['required', 'string'],
            'device_type' => ['nullable', 'string', 'max:50'],
            'device_name' => ['nullable', 'string'],
            'project' => ['nullable', 'string', 'max:50'],
        ];
    }
}
