<fieldset class="my-3">
    <legend class="fs-6">Accessory</legend>
    @foreach(['name' => 'Name', 'brand' => 'Brand', 'cost' => 'Cost'] as $field => $label)
        <label class="d-block">{{ $label }}<input name="accessories[{{ $index }}][{{ $field }}]" class="form-control"
                value="{{ $item[$field] ?? '' }}" type="{{ $field === 'cost' ? 'number' : 'text' }}" @if($field === 'cost')
                min="0" step="any" @endif @if($field === 'name') required @endif></label>
    @endforeach
    <label class="d-block">Enabled<select name="accessories[{{ $index }}][enabled]" class="form-select">
            <option value="1" @selected(($item['enabled'] ?? 1) == 1)>Yes</option>
            <option value="0" @selected(($item['enabled'] ?? 1) == 0)>No</option>
        </select></label>
    <button type="button" class="btn btn-outline-danger" title="Remove accessory"
        onclick="this.closest('fieldset').remove()"><iconify-icon icon="lucide:trash-2"></iconify-icon></button>
</fieldset>