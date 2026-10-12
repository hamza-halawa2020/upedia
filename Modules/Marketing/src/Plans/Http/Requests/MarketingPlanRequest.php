<?php

namespace Modules\Marketing\Plans\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class MarketingPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'month' => ['nullable', 'string', 'max:20'],
            'publish_date' => ['nullable', 'date', 'after_or_equal:today'],
            'publish_time' => ['nullable', 'date_format:H:i'],
            'platform' => ['required', 'in:facebook,tiktok,youtube,X,snapchat,instagram'],
            'status' => ['nullable', 'in:draft,under-review,ready-to-publish,not-approved,published'],
            'type' => ['required', 'in:script,content_plan,design,video'],
            'description' => ['nullable', 'string'],
            'comments' => ['nullable', 'string'],
            'attachments' => ['nullable', 'array', 'max:5'],
            'attachments.*' => ['file', 'mimes:pdf,jpg,png', 'max:5120'],
        ];
    }

    public function payload(): array
    {
        return Arr::except($this->validated(), ['attachments']);
    }
}

