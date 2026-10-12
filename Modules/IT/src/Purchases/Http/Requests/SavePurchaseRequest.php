<?php

namespace Modules\IT\Purchases\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SavePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return ['purchase_number' => ['required', 'string', 'max:255',
            Rule::unique('purchases', 'purchase_number')->ignore($this->route('purchase'))],
            'name' => ['required', 'string', 'max:255'],
            'required_by' => $this->isMethod('POST') ? ['required', 'date_format:Y-m-d', 'after_or_equal:today'] : ['required', 'date_format:Y-m-d'],
            'staff_id' => ['required', 'integer', 'exists:sm_staffs,id'],
            'vendor_ids' => ['required', 'array', 'min:1'], 'vendor_ids.*' => ['integer', 'distinct', 'exists:it_vendors,id'],
            'cost_center_id' => ['nullable', 'integer', 'exists:cost_centers,id'],
            'shipping_cost' => ['nullable', 'numeric', 'min:0'], 'items' => ['required', 'array', 'min:1'],
            'items.*.serial_number' => ['nullable', 'string', 'max:255'],
            'items.*.category' => ['required', 'string', 'max:255'],
            'items.*.product' => ['required', 'string', 'max:255'],
            'items.*.qty' => ['required', 'numeric', 'min:1'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
            'items.*.tax' => ['nullable', 'numeric', 'min:0'],
            'attachments' => ['nullable', 'array', 'max:5'],
            'attachments.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], 'status' => ['prohibited']];
    }
}
