@extends('layout.layout')

@section('content')
<div class="app-bg">
    <div class="page-shell space-y-4">
        <x-page-title title="Edit IT Product" />
        @include('components.alert')
        @include('it::products.partials.form', [
            'action' => route('it.products.update', $product->id), 'method' => 'PUT',
        ])
    </div>
</div>
@endsection
