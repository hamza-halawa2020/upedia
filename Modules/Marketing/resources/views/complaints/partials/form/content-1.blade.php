<div class="asset-form-grid">

    <div class="asset-col-6">
        <label class="asset-label">
            Platform <span class="text-danger">*</span>
        </label>

        <select name="platform" data-field="platform" class="asset-select @error('platform') asset-invalid @enderror" required>
            <option value="">Select Platform</option>
            @foreach (['facebook', 'tiktok', 'youtube', 'X', 'snapchat', 'instagram'] as $platform)
                <option value="{{ $platform }}"
                    {{ old('platform', $complain->platform ?? '') == $platform ? 'selected' : '' }}>
                    {{ ucfirst($platform) }}
                </option>
            @endforeach
        </select>

        <div class="invalid-feedback d-block {{ $errors->has('platform') ? '' : 'd-none' }}" data-error-for="platform">
            @error('platform'){{ $message }}@enderror
        </div>
    </div>

    <div class="asset-col-6">
        <label class="asset-label">
            Date <span class="text-danger">*</span>
        </label>

        <input
            type="date"
            name="date"
            data-field="date"
            class="asset-input @error('date') asset-invalid @enderror"
            value="{{ old('date', $complain->date ?? '') }}"
            required>

        <div class="invalid-feedback d-block {{ $errors->has('date') ? '' : 'd-none' }}" data-error-for="date">
            @error('date'){{ $message }}@enderror
        </div>
    </div>

    <div class="asset-col-6">
        <label for="staff_id" class="asset-label">
            Assigned Agent <span class="text-danger">*</span>
        </label>

        <select
            name="staff_id"
            id="staff_id"
            data-field="staff_id"
            class="asset-select @error('staff_id') asset-invalid @enderror"
            required>
            <option value="">Select Assigned Agent</option>

            @foreach ($salesStaff as $staff)
                <option value="{{ $staff->id }}"
                    {{ old('staff_id', $complain->staff_id ?? '') == $staff->id ? 'selected' : '' }}>
                    {{ $staff->first_name }} {{ $staff->last_name }}
                </option>
            @endforeach
        </select>

        <div class="invalid-feedback d-block {{ $errors->has('staff_id') ? '' : 'd-none' }}" data-error-for="staff_id">
            @error('staff_id'){{ $message }}@enderror
        </div>
    </div>

    <div class="asset-col-6">
        <label class="asset-label">
            Department <span class="text-danger">*</span>
        </label>

        <select name="department" id="department" data-field="department" class="asset-select @error('department') asset-invalid @enderror" required>
            <option value="">Select Department</option>
            <option value="sales" {{ old('department', $complain->department ?? 'sales') == 'sales' ? 'selected' : '' }}>
                Sales
            </option>
            <option value="retention" {{ old('department', $complain->department ?? '') == 'retention' ? 'selected' : '' }}>
                Retention
            </option>
        </select>

        <div class="invalid-feedback d-block {{ $errors->has('department') ? '' : 'd-none' }}" data-error-for="department">
            @error('department'){{ $message }}@enderror
        </div>
    </div>

    <div class="asset-col-6">
        <label class="asset-label">
            Case Type <span class="text-danger">*</span>
        </label>

        <select name="case_type" data-field="case_type" class="asset-select @error('case_type') asset-invalid @enderror" required>
            <option value="">Select Case Type</option>
            <option value="complaint" {{ old('case_type', $complain->case_type ?? 'complaint') == 'complaint' ? 'selected' : '' }}>
                Complaint Case
            </option>
            <option value="follow_up" {{ old('case_type', $complain->case_type ?? '') == 'follow_up' ? 'selected' : '' }}>
                Follow-up Case
            </option>
        </select>

        <div class="invalid-feedback d-block {{ $errors->has('case_type') ? '' : 'd-none' }}" data-error-for="case_type">
            @error('case_type'){{ $message }}@enderror
        </div>
    </div>

    <div class="asset-col-6">
        <label class="asset-label">
            System <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="system"
            data-field="system"
            class="asset-input @error('system') asset-invalid @enderror"
            value="{{ old('system', $complain->system ?? '') }}"
            placeholder="Enter system name"
            required>

        <div class="invalid-feedback d-block {{ $errors->has('system') ? '' : 'd-none' }}" data-error-for="system">
            @error('system'){{ $message }}@enderror
        </div>
    </div>

    <div class="asset-col-6">
        <label class="asset-label">
            Client Name
        </label>

        <input
            type="text"
            id="client_name"
            name="client_name"
            data-field="client_name"
            class="asset-input @error('client_name') asset-invalid @enderror"
            value="{{ old('client_name', $complain->client_name ?? '') }}"
            placeholder="Client name">

        <div class="field-note mt-2">
            <small class="text-muted">Client name is filled after selecting an existing phone number.</small>
        </div>

        <div class="invalid-feedback d-block {{ $errors->has('client_name') ? '' : 'd-none' }}" data-error-for="client_name">
            @error('client_name'){{ $message }}@enderror
        </div>
    </div>

    <div class="asset-col-6">
        <label class="asset-label">
            Client Number <span class="text-danger">*</span>
        </label>

        <div class="phone-lookup-wrap">
            <input
                type="tel"
                id="client_number"
                name="client_number"
                data-field="client_number"
                class="asset-input @error('client_number') asset-invalid @enderror"
                value="{{ old('client_number', $complain->client_number ?? '') }}"
                inputmode="numeric"
                autocomplete="off"
                placeholder="Client phone number"
                required>
