@extends('layout.layout')

@section('content')
<div class="app-bg">
    <div class="page-shell space-y-4">
        <x-page-title title="Create IT Product" />
        @include('components.alert')
        @include('it::products.partials.form', ['action' => route('it.products.store'), 'method' => 'POST'])
    </div>
</div>
@endsection
