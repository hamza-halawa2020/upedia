<?php

namespace Modules\IT\Assets\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveAssetRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->boolean('accessories_present') && ! $this->has('accessories')) {
            $this->merge(['accessories' => []]);
        }
    }

    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $rules = ['name' => ['required', 'string', 'max:255'], 'model' => ['required', 'string', 'max:255'],
            'product_id' => ['required', 'integer', 'exists:products,id'], 'vendor_id' => ['required', 'integer', 'exists:it_vendors,id'],
            'serial_number' => ['required', 'string', 'max:255', Rule::unique('assets')->ignore($this->route('asset'))],
            'purchase_cost' => ['required', 'numeric', 'min:0', 'max:9999999999999.99'],
            'acquisition_date' => ['required', 'date_format:Y-m-d'],
            'warranty_expiry_date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:acquisition_date'],
            'department_id' => ['nullable', 'integer', 'exists:sm_human_departments,id'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'ram' => ['nullable', 'integer', 'min:1'],
            'is_currently_in_use' => ['nullable', Rule::in(['in_use', 'in_store', 'in_repair'])],
            'accessories' => ['sometimes', 'array', 'max:50'],
            'accessories.*.name' => ['required', 'string', 'max:255', 'distinct'],
            'accessories.*.brand' => ['nullable', 'string', 'max:255'],
            'accessories.*.cost' => ['nullable', 'numeric', 'min:0'],
            'accessories.*.enabled' => ['required', 'boolean']];
        foreach (['manufacturer', 'barcode', 'site', 'processor', 'hard_disk'] as $field) {
            $rules[$field] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }
}
