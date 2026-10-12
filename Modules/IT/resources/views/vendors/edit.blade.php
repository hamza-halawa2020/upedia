@extends('layout.layout')

@section('content')
<div class="app-bg"><div class="page-shell">
    <x-page-title title="Edit Vendor" />
    @include('it::vendors.partials.form', ['action' => route('it.vendors.update', $vendor->id), 'method' => 'PUT'])
</div></div>
@endsection
