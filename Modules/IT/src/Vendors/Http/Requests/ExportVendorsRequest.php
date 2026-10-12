<?php

namespace Modules\IT\Vendors\Http\Requests;

use Illuminate\Validation\Rule;

class ExportVendorsRequest extends ListVendorsRequest
{
    public function rules(): array
    {
        return parent::rules() + ['format' => ['sometimes', Rule::in(['xlsx', 'csv'])]];
    }
}
