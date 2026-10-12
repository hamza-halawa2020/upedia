<?php

namespace Modules\Notifications\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FirebaseConfigRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return ['first_notification_before' => ['required', 'integer', 'min:1'],
            'second_notification_after' => ['required', 'integer', 'min:1'],
            'working_hour_start' => ['required', 'integer', 'min:0', 'max:23'],
            'working_hour_end' => ['required', 'integer', 'min:0', 'max:23', 'gt:working_hour_start']];
    }
}
