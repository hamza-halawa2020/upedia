@extends('layout.layout')

@section('content')
<div class="app-bg">
    <div class="page-shell space-y-4">
        <x-page-title title="IT Products">
            @can('it_products_create')
                <x-table-action type="create" :url="route('it.products.create')" label="Add Product" />
            @endcan
        </x-page-title>
        @include('components.alert')
        <x-table-controls :action="route('it.products.index')" />
        <div class="ui-table-wrap nice-scrollbar">
            <table class="ui-table">
                <thead class="ui-table__head">
                    <tr><th>#</th><th>Product Name</th><th class="text-center">Actions</th></tr>
                </thead>
                <tbody class="ui-table__body">
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $products->firstItem() + $loop->index }}</td>
                            <td>{{ $product->name }}</td>
                            <td class="text-center">
                                @can('it_products_show')
                                    <x-table-action type="view" :url="route('it.products.show', $product->id)" />
                                @endcan
                                @can('it_products_edit')
                                    <x-table-action type="edit" :url="route('it.products.edit', $product->id)" />
                                @endcan
                                @can('it_products_destroy')
                                    <form action="{{ route('it.products.destroy', $product->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Delete this product and all its assets?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-table-action type="delete" buttonType="submit" />
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">No products found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $products->links() }}
    </div>
</div>
@endsection
