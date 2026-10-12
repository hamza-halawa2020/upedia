@extends('layout.layout')
@section('content')
<div class="app-bg"><div class="page-shell">
    <x-page-title :title="$solution ? 'Edit Solution' : 'Add Solution'" />
    @if($errors->any())<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
    <form method="POST" enctype="multipart/form-data" action="{{ $solution ? route('it.it-solutions.update', $solution->id) : route('it.it-solutions.store') }}">
        @csrf @if($solution) @method('PUT') @endif
        @foreach(['title' => 'Title', 'topic_name' => 'Topic', 'keywords' => 'Keywords'] as $field => $label)
            <label for="{{ $field }}" class="form-label">{{ $label }}</label>
            <input id="{{ $field }}" class="form-control mb-3" name="{{ $field }}" value="{{ old($field, $solution?->{$field}) }}" @if($field !== 'keywords') required maxlength="255" @endif>
        @endforeach
        <label for="description" class="form-label">Description</label>
        <textarea id="description" class="form-control mb-3" name="description" rows="8" required>{{ old('description', $solution?->description) }}</textarea>
        <label for="visibility" class="form-label">Visibility</label>
        <select id="visibility" class="form-select mb-3" name="visibility">
            @foreach(['all' => 'Everyone', 'it_only' => 'IT Team', 'departments' => 'Selected Departments'] as $value => $label)
                <option value="{{ $value }}" @selected(old('visibility', $solution?->visibility) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <fieldset class="mb-3"><legend class="fs-6">Departments</legend>
            @foreach($departments as $department)
                <label class="d-block"><input type="checkbox" name="department_ids[]" value="{{ $department->id }}"
                    @checked(in_array($department->id, old('department_ids', $solution?->departments->pluck('id')->all() ?? [])))> {{ $department->name }}</label>
            @endforeach
        </fieldset>
        <button type="submit" class="btn btn-primary"><iconify-icon icon="lucide:save"></iconify-icon> Save</button>
        <a href="{{ route('it.it-solutions.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <label class="form-label" for="attachments">Attachments</label>
        <input id="attachments" type="file" name="attachments[]" multiple accept=".pdf,.jpg,.jpeg,.png" class="form-control mb-3">
    </form>
</div></div>
@endsection
