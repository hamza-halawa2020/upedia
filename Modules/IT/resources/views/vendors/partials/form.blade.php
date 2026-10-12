<form action="{{ $action }}" method="POST">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif
    @foreach(['name' => 'Vendor Name', 'phone' => 'Phone', 'location' => 'Location', 'tax' => 'Tax (%)', 'shipping_cost' => 'Shipping Cost'] as $field => $label)
        <div class="mb-4">
            <label for="vendor-{{ $field }}" class="form-label">{{ $label }}</label>
            <input id="vendor-{{ $field }}" name="{{ $field }}"
                type="{{ in_array($field, ['tax', 'shipping_cost']) ? 'number' : 'text' }}"
                @if(in_array($field, ['tax', 'shipping_cost'])) min="0" step="any"
                @else required maxlength="{{ $field === 'phone' ? 20 : 255 }}" @endif
                value="{{ old($field, isset($vendor) ? $vendor->{$field} : '') }}"
                class="form-control @error($field) is-invalid @enderror">
            @error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    @endforeach
    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('it.vendors.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">
            <iconify-icon icon="lucide:save"></iconify-icon> Save Vendor
        </button>
    </div>
</form>
