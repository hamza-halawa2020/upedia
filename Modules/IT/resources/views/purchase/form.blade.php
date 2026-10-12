@extends('layout.layout')
@section('content')
<div class="app-bg"><div class="page-shell">
    <x-page-title :title="$purchase ? 'Edit Purchase' : 'Add Purchase'" />
    @if($errors->any())<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
    <form method="POST" enctype="multipart/form-data" action="{{ $purchase ? route('it.purchase.update', $purchase->id) : route('it.purchase.store') }}">
        @csrf @if($purchase) @method('PUT') @endif
        @foreach(['purchase_number' => 'Number', 'name' => 'Name', 'required_by' => 'Required By', 'shipping_cost' => 'Shipping'] as $field => $label)
            <label class="form-label" for="{{ $field }}">{{ $label }}</label>
            <input id="{{ $field }}" name="{{ $field }}" class="form-control mb-3" value="{{ old($field, $purchase?->{$field}) }}"
                type="{{ $field === 'required_by' ? 'date' : ($field === 'shipping_cost' ? 'number' : 'text') }}"
                @if($field === 'shipping_cost') min="0" step="any" @else required @endif>
        @endforeach
        <label for="staff" class="form-label">Requester</label>
        <select id="staff" name="staff_id" class="form-select mb-3" required><option value="">Select requester</option>
            @foreach($staffs as $staff)<option value="{{ $staff->id }}" @selected(old('staff_id', $purchase?->requestedStaffs->first()?->id) == $staff->id)>{{ $staff->first_name }} {{ $staff->last_name }}</option>@endforeach
        </select>
        <label for="cost-center" class="form-label">Cost Center</label>
        <select id="cost-center" name="cost_center_id" class="form-select mb-3"><option value="">None</option>
            @foreach($costCenters as $center)<option value="{{ $center->id }}" @selected(old('cost_center_id', $purchase?->cost_center_id) == $center->id)>{{ $center->title }}</option>@endforeach
        </select>
        <fieldset><legend class="fs-6">Vendors</legend>
            @foreach($vendors as $vendor)<label class="d-block"><input type="checkbox" name="vendor_ids[]" value="{{ $vendor->id }}"
                @checked(in_array($vendor->id, old('vendor_ids', $purchase?->vendors->pluck('id')->all() ?? [])))> {{ $vendor->name }}</label>@endforeach
        </fieldset>
        @php($items = old('items', $purchase?->details->map(fn ($item) => ['serial_number' => $item->serial_number, 'category' => $item->category_name, 'product' => $item->product_name, 'qty' => $item->quantity, 'unit_price' => $item->price, 'tax' => $item->tax_rate])->all() ?? [['qty' => 1, 'tax' => 0]]))
        <div id="purchase-items">
            @foreach($items as $index => $item)
                <fieldset class="my-3 purchase-item"><legend class="fs-6">Item</legend>
                    @foreach(['serial_number' => 'Serial', 'category' => 'Category', 'product' => 'Product', 'qty' => 'Quantity', 'unit_price' => 'Unit Price', 'tax' => 'Tax (%)'] as $field => $label)
                        <label class="d-block">{{ $label }}<input class="form-control" data-field="{{ $field }}" name="items[{{ $index }}][{{ $field }}]" value="{{ $item[$field] ?? '' }}"
                            type="{{ in_array($field, ['qty', 'unit_price', 'tax']) ? 'number' : 'text' }}"
                            @if(in_array($field, ['qty', 'unit_price', 'tax'])) min="{{ $field === 'qty' ? 1 : 0 }}" step="any" @endif
                            @if(!in_array($field, ['serial_number', 'tax'])) required @endif></label>
                    @endforeach
                    <button type="button" class="btn btn-outline-danger mt-2" onclick="if(document.querySelectorAll('.purchase-item').length > 1) this.closest('fieldset').remove()" title="Remove item"><iconify-icon icon="lucide:trash-2"></iconify-icon></button>
                </fieldset>
            @endforeach
        </div>
        <button type="button" id="add-item" class="btn btn-outline-secondary"><iconify-icon icon="lucide:plus"></iconify-icon> Add Item</button>
        <button type="submit" class="btn btn-primary"><iconify-icon icon="lucide:save"></iconify-icon> Save</button>
        <label class="form-label" for="attachments">Attachments</label>
        <input id="attachments" type="file" name="attachments[]" multiple accept=".pdf,.jpg,.jpeg,.png" class="form-control mb-3">
    </form>
</div></div>
<script>
    document.getElementById('add-item').addEventListener('click', () => {
        const container = document.getElementById('purchase-items');
        const item = container.firstElementChild.cloneNode(true);
        const index = Date.now();
        item.querySelectorAll('input').forEach(input => {
            input.name = `items[${index}][${input.dataset.field}]`;
            input.value = input.dataset.field === 'qty' ? 1 : '';
        });
        container.appendChild(item);
    });
</script>
@endsection
