@extends('layout.layout')
@section('content')
<div class="app-bg"><div class="page-shell">
    <x-page-title :title="$catalog->title()" />
    @include('components.alert')
    <form method="POST" action="{{ $record ? route('it.'.$catalog->value.'.update', $record->id) : route('it.'.$catalog->value.'.store') }}">
        @csrf
        @if($record) @method('PUT') @endif
        <label class="form-label" for="name">Name</label>
        <input class="form-control mb-3" id="name" name="name" maxlength="255" required value="{{ old('name', $record?->name) }}">
        @if($catalog->value === 'ticket-priorities')
            <label class="form-label" for="sla-hours">SLA Hours</label>
            <input class="form-control mb-3" id="sla-hours" name="sla_hours" type="number" min="1" required value="{{ old('sla_hours', $record?->sla_hours) }}">
        @else
            @php($field = $catalog->value === 'ticket-categories' ? 'parent_id' : 'ticket_subcategory_id')
            <label class="form-label" for="category">{{ $field === 'parent_id' ? 'Parent Category' : 'Subcategory' }}</label>
            <select class="form-select mb-3" id="category" name="{{ $field }}" @if($field !== 'parent_id') required @endif>
                <option value="">{{ $field === 'parent_id' ? 'Main category' : 'Select subcategory' }}</option>
                @foreach($categories as $category)
                    @if(($field === 'parent_id' && !$category->parent_id && $category->id !== $record?->id) || ($field !== 'parent_id' && $category->parent_id))
                        <option value="{{ $category->id }}" @selected(old($field, $record?->{$field}) == $category->id)>
                            {{ $category->parent?->name ? $category->parent->name.' / ' : '' }}{{ $category->name }}
                        </option>
                    @endif
                @endforeach
            </select>
            @if($catalog->value === 'ticket-categories')
                <label class="form-label" for="priority">Priority</label>
                <select class="form-select mb-3" id="priority" name="priority_id">
                    <option value="">None</option>
                    @foreach($priorities as $priority)
                        <option value="{{ $priority->id }}" @selected(old('priority_id', $record?->priority_id) == $priority->id)>{{ $priority->name }}</option>
                    @endforeach
                </select>
            @endif
        @endif
        @if($errors->any())<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
        <button class="btn btn-primary" type="submit"><iconify-icon icon="lucide:save"></iconify-icon> Save</button>
        <a class="btn btn-outline-secondary" href="{{ route('it.'.$catalog->value.'.index') }}">Cancel</a>
    </form>
</div></div>
@endsection
