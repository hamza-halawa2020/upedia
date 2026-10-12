<form action="{{ $action }}" method="POST">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif
    <div class="mb-4">
        <label for="product-name" class="form-label">Product Name</label>
        <input id="product-name" name="name" type="text" maxlength="255" required
            value="{{ old('name', $product->name ?? '') }}"
            class="form-control @error('name') is-invalid @enderror">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('it.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">
            <iconify-icon icon="lucide:save"></iconify-icon> Save Product
        </button>
    </div>
</form>
