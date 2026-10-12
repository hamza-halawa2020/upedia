@extends('layout.layout')

@section('content')
<div class="app-bg">
    <div class="page-shell space-y-4">
        <x-page-title :title="$product->name">
            <a href="{{ route('it.products.index') }}" class="btn btn-outline-secondary">
                <iconify-icon icon="lucide:arrow-left"></iconify-icon> Products
            </a>
        </x-page-title>
        @include('components.alert')
        <dl><dt>Product Name</dt><dd>{{ $product->name }}</dd></dl>
        @can('it_products_edit')
            <x-table-action type="edit" :url="route('it.products.edit', $product->id)" label="Edit Product" />
        @endcan
    </div>
</div>
@endsection
