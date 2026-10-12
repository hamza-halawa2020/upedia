
    @if ($isSuperAdmin || $deptSlug === 'complain' || $deptSlug === 'marketing')
        <div class="asset-col-6">
            <label class="asset-label">
                Status <span class="text-danger">*</span>
            </label>

            <select name="status" data-field="status" class="asset-select @error('status') asset-invalid @enderror">
                <option value="not_solved"
                    {{ old('status', $complain->status ?? '') == 'not_solved' ? 'selected' : '' }}>
                    Not Solved
                </option>
                <option value="solved"
                    {{ old('status', $complain->status ?? '') == 'solved' ? 'selected' : '' }}>
                    Solved
                </option>
            </select>

            <div class="invalid-feedback d-block {{ $errors->has('status') ? '' : 'd-none' }}" data-error-for="status">
                @error('status'){{ $message }}@enderror
            </div>
        </div>
    @endif

    <div class="asset-col-6">
        <label class="asset-label">
            Priority <span class="text-danger">*</span>
        </label>

        <select name="priority" data-field="priority" class="asset-select @error('priority') asset-invalid @enderror" required>
            <option value="">Select Priority</option>
            <option value="low" {{ old('priority', $complain->priority ?? '') == 'low' ? 'selected' : '' }}>
                Low
            </option>
            <option value="medium" {{ old('priority', $complain->priority ?? '') == 'medium' ? 'selected' : '' }}>
                Medium
            </option>
            <option value="high" {{ old('priority', $complain->priority ?? '') == 'high' ? 'selected' : '' }}>
                High
            </option>
        </select>

        <div class="invalid-feedback d-block {{ $errors->has('priority') ? '' : 'd-none' }}" data-error-for="priority">
            @error('priority'){{ $message }}@enderror
        </div>
    </div>

    <div class="asset-col-12">
        <label class="asset-label">
            Note
        </label>

        <textarea
            name="note"
            rows="4"
            data-field="note"
            class="asset-input asset-textarea @error('note') asset-invalid @enderror"
            placeholder="Write complaint details or client message">{{ old('note', $complain->note ?? '') }}</textarea>

        <div class="invalid-feedback d-block {{ $errors->has('note') ? '' : 'd-none' }}" data-error-for="note">
            @error('note'){{ $message }}@enderror
        </div>
    </div>

    <div class="asset-col-12">
        <label class="asset-label">
            Moderator Note
        </label>

        <textarea
            name="moderator_note"
            rows="4"
            data-field="moderator_note"
            class="asset-input asset-textarea @error('moderator_note') asset-invalid @enderror"
            placeholder="Internal note for moderator or complaint team">{{ old('moderator_note', $complain->moderator_note ?? '') }}</textarea>

        <div class="invalid-feedback d-block {{ $errors->has('moderator_note') ? '' : 'd-none' }}" data-error-for="moderator_note">
            @error('moderator_note'){{ $message }}@enderror
        </div>
    </div>

    <div class="asset-col-12">
        <label class="asset-label">
            Attachments
        </label>

        <div class="upload-box">
            <input
                type="file"
                name="attachments[]"
                data-field="attachments"
                class="asset-input @error('attachments.*') asset-invalid @enderror"
                multiple>

            <div class="field-note mt-2">
                <small class="text-muted">
                    You can upload multiple files related to this complaint.
                </small>
            </div>
        </div>

        <div class="invalid-feedback d-block {{ $errors->has('attachments') || $errors->has('attachments.*') ? '' : 'd-none' }}" data-error-for="attachments">
            @error('attachments'){{ $message }}@enderror
            @error('attachments.*'){{ $message }}@enderror
        </div>

        @if (isset($complain) && $complain->attachments->count())
            <div class="existing-attachments mt-3">
                <div class="existing-attachments__title">
                    Existing Attachments
                </div>

                <div class="attachment-list">
                    @foreach ($complain->attachments as $file)
                        <a href="{{ route('attachments.show', $file->id) }}" target="_blank" class="attachment-chip">
                            <iconify-icon icon="mdi:paperclip"></iconify-icon>
                            <span>{{ basename($file->file_path) }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

</div>

