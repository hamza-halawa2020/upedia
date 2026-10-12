@extends('layout.layout')
@section('content')
    <div class="app-bg">
        <div class="page-shell">
            <x-page-title :title="$ticket->title" />
            <dl>
                <dt>Status</dt>
                <dd>{{ $ticket->status }}</dd>
                <dt>Category</dt>
                <dd>{{ $ticket->category?->name }}</dd>
                <dt>Deadline</dt>
                <dd>{{ $ticket->resolution_time }}</dd>
                <dt>Reopened</dt>
                <dd>{{ $ticket->reopen_count ?? 0 }}</dd>
            </dl>
            <div style="white-space: pre-wrap">{{ $ticket->description }}</div>
            <div style="white-space: pre-wrap">{{ $ticket->resolution_description }}</div>
            <a href="{{ route('it.tickets.index') }}">Back</a>
        </div>
    </div>
@endsection