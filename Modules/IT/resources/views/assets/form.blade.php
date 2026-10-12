@extends('layout.layout')
@section('content')
<div class="app-bg">
    <div class="page-shell">
        <x-page-title :title="$asset ? 'Edit Asset' : 'Add Asset'" />
        @if($errors->any())
            <ul>@foreach($errors->all() as $error)
            <li>{{ $error }}</li>@endforeach
        </ul>@endif
        <form method="POST" action="{{ $asset ? route('it.asset.update', $asset->id) : route('it.asset.store') }}">
            @csrf @if($asset) @method('PUT') @endif
            @foreach(['name', 'model', 'serial_number', 'manufacturer', 'barcode', 'purchase_cost', 'acquisition_date', 'warranty_expiry_date', 'site', 'processor', 'hard_disk', 'ram'] as $field)
                <label class="form-label" for="{{ $field }}">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                <input id="{{ $field }}" name="{{ $field }}" class="form-control mb-3"
                    value="{{ old($field, str_ends_with($field, '_date') ? $asset?->{$field}?->format('Y-m-d') : $asset?->{$field}) }}"
                    type="{{ str_ends_with($field, '_date') ? 'date' : (in_array($field, ['purchase_cost', 'ram']) ? 'number' : 'text') }}"
                    @if(in_array($field, ['purchase_cost', 'ram'])) min="{{ $field === 'ram' ? 1 : 0 }}"
                    step="{{ $field === 'ram' ? 1 : 'any' }}" @endif @if(in_array($field, ['name', 'model', 'serial_number', 'purchase_cost', 'acquisition_date'])) required @endif>
            @endforeach
            @foreach(['product_id' => $products, 'vendor_id' => $vendors, 'department_id' => $departments, 'user_id' => $users] as $field => $options)
                <label for="{{ $field }}" class="form-label">{{ ucwords(str_replace('_id', '', $field)) }}</label>
                <select id="{{ $field }}" name="{{ $field }}" class="form-select mb-3" @if(in_array($field, ['product_id', 'vendor_id'])) required @endif>
                    <option value="">Select</option>
                    @foreach($options as $option)
                        <option value="{{ $option->id }}" @selected(old($field, $asset?->{$field}) == $option->id)>
                            {{ $option->name ?? $option->full_name }}
                    </option>@endforeach
                </select>
            @endforeach
            <label for="asset-status" class="form-label">Status</label>
            <select id="asset-status" name="is_currently_in_use" class="form-select mb-3">
                @foreach(['in_store' => 'In Store', 'in_use' => 'In Use', 'in_repair' => 'In Repair'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('is_currently_in_use', $asset?->is_currently_in_use) === $value)>{{ $label }}</option>
                @endforeach
            </select>
            @php($items = old('accessories', $asset?->accessories->map(fn($item) => ['name' => $item->type, 'brand' => $item->brand, 'cost' => $item->cost, 'enabled' => (int) $item->enabled])->all() ?? []))
            <input type="hidden" name="accessories_present" value="1">
            <div id="accessory-items">@foreach($items as $index => $item)
                @include('it::assets.partials.accessory', ['index' => $index, 'item' => $item])
            @endforeach
            </div>
            <template
                id="accessory-template">@include('it::assets.partials.accessory', ['index' => 'INDEX', 'item' => []])</template>
            <button type="button" id="add-accessory" class="btn btn-outline-secondary"><iconify-icon
                    icon="lucide:plus"></iconify-icon> Add Accessory</button>
            <button class="btn btn-primary" type="submit"><iconify-icon icon="lucide:save"></iconify-icon> Save</button>
        </form>
    </div>
</div>
<script>
    document.getElementById('add-accessory').addEventListener('click', () => {
        const html = document.getElementById('accessory-template').innerHTML.replaceAll('INDEX', Date.now());
        document.getElementById('accessory-items').insertAdjacentHTML('beforeend', html);
    });
</script>
@endsection