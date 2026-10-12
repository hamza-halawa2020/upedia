@extends('layout.layout')
@section('content')
    <div class="app-bg">
        <div class="page-shell">
            <x-page-title :title="$ticket ? 'Edit Ticket' : 'Add Ticket'" />
            @if($errors->any())
                <ul>@foreach($errors->all() as $error)
                <li>{{ $error }}</li>@endforeach
            </ul>@endif
            <form method="POST" enctype="multipart/form-data"
                action="{{ $ticket ? route('it.tickets.update', $ticket->id) : route('it.tickets.store') }}">
                @csrf @if($ticket) @method('PUT') @endif
                <label for="title" class="form-label">Title</label><input class="form-control mb-3" id="title" name="title"
                    required maxlength="255" value="{{ old('title', $ticket?->title) }}">
                @foreach(['description' => 'Description', 'resolution_description' => 'Resolution'] as $field => $label)
                    <label class="form-label" for="{{ $field }}">{{ $label }}</label>
                    <textarea id="{{ $field }}" class="form-control mb-3" name="{{ $field }}" rows="4"
                        @if($field === 'description') required @endif>{{ old($field, $ticket?->{$field}) }}</textarea>
                @endforeach
                @foreach(['ticket_category_id' => $categories->whereNull('parent_id'), 'ticket_subcategory_id' => $categories->whereNotNull('parent_id'), 'ticket_item_id' => $items, 'ticket_priority_id' => $priorities, 'requester_id' => $staffs, 'assigned_to' => $staffs] as $field => $options)
                    <label for="{{ $field }}"
                        class="form-label">{{ ucwords(str_replace('_', ' ', str_replace('_id', '', $field))) }}</label>
                    <select id="{{ $field }}" name="{{ $field }}" class="form-select mb-3" @if(in_array($field, ['ticket_category_id', 'ticket_priority_id', 'requester_id'])) required @endif>
                        <option value="">Select</option>
                        @foreach($options as $option)
                            <option value="{{ $option->id }}" @selected(old($field, $ticket?->{$field}) == $option->id)
                                @if($field === 'ticket_subcategory_id') data-parent="{{ $option->parent_id }}" @endif
                                @if($field === 'ticket_item_id') data-parent="{{ $option->ticket_subcategory_id }}" @endif>
                                {{ $option->name ?? trim($option->first_name . ' ' . $option->last_name) }}
                        </option>@endforeach
                    </select>
                @endforeach
                @include('it::tickets.partials.requester-details')
                @foreach(['status' => ['open', 'pending', 'in_progress', 'closed'], 'request_type' => ['issue', 'request', 'inquiry']] as $field => $options)
                    <label for="{{ $field }}" class="form-label">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                    <select id="{{ $field }}" name="{{ $field }}" class="form-select mb-3">
                        @foreach($options as $value)
                            <option value="{{ $value }}" @selected(old($field, $ticket?->{$field}) === $value)>
                                {{ ucwords(str_replace('_', ' ', $value)) }}
                        </option>@endforeach
                    </select>
                @endforeach
                <button type="submit" class="btn btn-primary"><iconify-icon icon="lucide:save"></iconify-icon> Save</button>
                <a href="{{ route('it.tickets.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <label class="form-label" for="attachments">Attachments</label>
                <input id="attachments" type="file" name="attachments[]" multiple accept=".pdf,.jpg,.jpeg,.png"
                    class="form-control mb-3">
            </form>
        </div>
    </div>
    <script>
        function filterChildren(parentId, childId) {
            const parent = document.getElementById(parentId), child = document.getElementById(childId);
            child.querySelectorAll('option[data-parent]').forEach(option => {
                option.hidden = option.dataset.parent !== parent.value;
                option.disabled = option.hidden;
                if (option.hidden && option.selected) child.value = '';
            });
        }
        function syncTicketCategories() {
            filterChildren('ticket_category_id', 'ticket_subcategory_id');
            filterChildren('ticket_subcategory_id', 'ticket_item_id');
        }
        document.getElementById('ticket_category_id').addEventListener('change', syncTicketCategories);
        document.getElementById('ticket_subcategory_id').addEventListener('change', syncTicketCategories);
        syncTicketCategories();
    </script>
@endsection