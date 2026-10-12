@extends('layout.layout')

@section('content')
<div class="app-bg"><div class="page-shell">
    <x-page-title title="Add Vendor" />
    @include('it::vendors.partials.form', ['action' => route('it.vendors.store'), 'method' => 'POST'])
</div></div>
@endsection
