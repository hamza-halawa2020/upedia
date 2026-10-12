<div class="quick-link-item" data-id="{{ $link->id }}">
    <div class="quick-link-item__head">
        <div>
            <div class="quick-link-item__title">Quick Link #{{ $link->id }}</div>
            <div class="quick-link-item__sub">Configure link details and department visibility.</div>
        </div>

        <div class="quick-link-item__badge {{ $link->is_active ? 'is-active' : 'is-inactive' }}">
            {{ $link->is_active ? 'Active' : 'Inactive' }}
        </div>
    </div>

    <div class="quick-link-grid">
        <div class="quick-link-field">
            <label class="asset-label">Name</label>
            <input type="text" name="name" class="asset-input" value="{{ $link->name }}">
        </div>

        <div class="quick-link-field">
            <label class="asset-label">URL</label>
            <input type="url" name="link" class="asset-input" value="{{ $link->link }}">
        </div>

        <div class="quick-link-field quick-link-field--departments">
            <label class="asset-label">Departments</label>
            <select name="department_ids[]" class="asset-select general-select" multiple>
                @foreach ($departments as $dept)
                    <option value="{{ $dept->id }}" {{ $link->departments->contains($dept->id) ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="quick-link-footer">
        <div class="quick-link-status-block">
            <label class="asset-label mb-0">Status</label>
            <div class="quick-link-switch">
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                        {{ $link->is_active ? 'checked' : '' }} onchange="updateStatusBadge(this)">
                </div>
                <span class="quick-link-switch__text">{{ $link->is_active ? 'Enabled' : 'Disabled' }}</span>
            </div>
        </div>

        <div class="quick-link-actions">
            <button type="button" class="asset-btn asset-btn--primary" onclick="saveQuickLink(this)">Save</button>
            <button type="button" class="asset-btn asset-btn--danger" onclick="removeQuickLink(this)">Remove</button>
        </div>
    </div>
</div>
