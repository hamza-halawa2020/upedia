@extends('layout.layout')
@section('content')
<div class="app-bg"><div class="page-shell">
    <x-page-title :title="$record->name" />
    <dl>
        @foreach($record->only(['name', 'sla_hours', 'parent_id', 'priority_id', 'ticket_subcategory_id']) as $key => $value)
            <dt>{{ ucwords(str_replace('_', ' ', $key)) }}</dt><dd>{{ $value ?? '-' }}</dd>
        @endforeach
    </dl>
    <a href="{{ route('it.'.$catalog->value.'.index') }}">Back</a>
</div></div>
@endsection
