<template id="quick-link-template">
    <div class="quick-link-item" data-id="new">
        <div class="quick-link-item__head">
            <div>
                <div class="quick-link-item__title">New Quick Link</div>
                <div class="quick-link-item__sub">Add a new internal tool or department link.</div>
            </div>

            <div class="quick-link-item__badge is-active">Active</div>
        </div>

        <div class="quick-link-grid">
            <div class="quick-link-field">
                <label class="asset-label">Name</label>
                <input type="text" name="name" class="asset-input" placeholder="New Tool">
            </div>

            <div class="quick-link-field">
                <label class="asset-label">URL</label>
                <input type="url" name="link" class="asset-input" placeholder="https://...">
            </div>

            <div class="quick-link-field quick-link-field--departments">
                <label class="asset-label">Departments</label>
                <select name="department_ids[]" class="asset-select department-select" multiple>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="quick-link-footer">
            <div class="quick-link-status-block">
                <label class="asset-label mb-0">Status</label>
                <div class="quick-link-switch">
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" checked
                            onchange="updateStatusBadge(this)">
                    </div>
                    <span class="quick-link-switch__text">Enabled</span>
                </div>
            </div>

            <div class="quick-link-actions">
                <button type="button" class="asset-btn asset-btn--primary" onclick="saveQuickLink(this)">Add</button>
                <button type="button" class="asset-btn asset-btn--danger" onclick="removeQuickLink(this)">Remove</button>
            </div>
        </div>
    </div>
</template>
