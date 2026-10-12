<?php

namespace Modules\Marketing\Plans\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalendarEventsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'statuses' => ['nullable', 'string'],
            'platforms' => ['nullable', 'string'],
        ];
    }

    public function criteria(): array
    {
        return $this->validated();
    }
}

