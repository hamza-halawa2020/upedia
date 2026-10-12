@extends('layout.layout')
@section('content')
    <div class="app-bg">
        <div class="page-shell">
            <x-page-title title="Notification Configuration" />
            @include('components.alert')
            @if($errors->any())
                <ul>@foreach($errors->all() as $error)
                <li>{{ $error }}</li>@endforeach
            </ul>@endif
            <form method="POST" action="{{ route('firebase-configs.store') }}">
                @csrf
                @foreach(['first_notification_before' => 'First Notification Before (Minutes)', 'second_notification_after' => 'Second Notification After (Minutes)', 'working_hour_start' => 'Working Hour Start', 'working_hour_end' => 'Working Hour End'] as $field => $label)
                    <label class="form-label" for="{{ $field }}">{{ $label }}</label>
                    <input class="form-control mb-3" id="{{ $field }}" name="{{ $field }}" type="number" required
                        min="{{ str_starts_with($field, 'working_') ? 0 : 1 }}" @if(str_starts_with($field, 'working_'))
                        max="23" @endif
                        value="{{ old($field, $config?->{$field} ?? match ($field) { 'working_hour_start' => 8, 'working_hour_end' => 16, default => 30}) }}">
                @endforeach
                <button class="btn btn-primary" type="submit"><iconify-icon icon="lucide:save"></iconify-icon> Save</button>
            </form>
        </div>
    </div>
@endsection