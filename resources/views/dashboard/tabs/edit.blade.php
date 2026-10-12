<!-- Edit Modal -->
<div class="modal fade" id="editModal{{ $tab->id }}" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('tabs.update', $tab->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <div class="modal-title">Edit Tab</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="label" class="form-label">Label</label>
                        <input type="text" class="form-control" name="label"
                            value="{{ $tab->label }}" required>
                    </div>


                    <div class="mb-3">
                        <label for="icon" class="form-label">Icon</label>
                        <input type="hidden" class="form-control selected-icon"
                            name="icon" value="{{ $tab->icon }}" readonly>
                        <iconify-icon icon="{{ $tab->icon }}"
                            width="24"></iconify-icon>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Choose Icon</label>
                        <div class="icon-grid d-flex flex-wrap gap-2"
                            data-modal-id="editModal{{ $tab->id }}">
                            <div class="text-center w-100 p-3">
                                <div class="spinner-border spinner-border-sm"
                                    role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="mt-2">Loading icons...</div>
                            </div>
                        </div>
                    </div>

                    @if ($tab->parent_id != null)
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Parent
                                Tab</label>
                            <select name="parent_id" class="form-select">
                                <option value="">None</option>
                                @foreach ($parentTabs->where('id', '!=', $tab->id) as $parent)
                                    <option value="{{ $parent->id }}"
                                        {{ $tab->parent_id == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="order" class="form-label">Order</label>
                        <input type="number" class="form-control" name="order"
                            value="{{ $tab->order }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Systems</label>
                        <div class="d-flex flex-wrap gap-2">
                            @php
                                $tabSystems = $tab->systems ?? [];
                            @endphp
                            @foreach (['settings', 'hr', 'crm', 'academy', 'finance', 'retention', 'it', 'marketing'] as $sys)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="systems[]" value="{{ $sys }}" id="edit_sys_{{ $sys }}_{{ $tab->id }}"
                                        {{ in_array($sys, $tabSystems) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="edit_sys_{{ $sys }}_{{ $tab->id }}">
                                        {{ strtoupper($sys) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
