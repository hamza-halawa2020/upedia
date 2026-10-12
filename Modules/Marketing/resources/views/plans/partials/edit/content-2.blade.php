
                                    @error('platform')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="asset-col-6">
                                    <label for="type" class="asset-label">
                                        Type <span class="text-danger">*</span>
                                    </label>

                                    <select
                                        id="type"
                                        name="type"
                                        class="asset-select @error('type') asset-invalid @enderror"
                                        required>

                                        <option value="">Select Type</option>

                                        @foreach (['script', 'content_plan', 'design', 'video'] as $t)
                                            <option value="{{ $t }}"
                                                {{ old('type', $plan->type) == $t ? 'selected' : '' }}>
                                                {{ ucwords(str_replace('_', ' ', $t)) }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('type')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if ($staff && $staff->jobTitle && $staff->jobTitle->slug == 'marketing_manager')
                                    <div class="asset-col-6">
                                        <label for="status" class="asset-label">
                                            Status
                                        </label>

                                        <select
                                            id="status"
                                            name="status"
                                            class="asset-select @error('status') asset-invalid @enderror">

                                            <option value="">Select Status</option>

                                            @foreach (['draft', 'under-review', 'ready-to-publish', 'not-approved', 'published'] as $status)
                                                <option value="{{ $status }}"
                                                    {{ old('status', $plan->status) == $status ? 'selected' : '' }}>
                                                    {{ ucfirst(str_replace('-', ' ', $status)) }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('status')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="ui-card">
                        <div class="form-section">

                            <div class="form-section__head">
                                <h5 class="form-section__title mb-1">Plan Content</h5>
                                <p class="form-section__sub mb-0">
                                    Update the plan description and internal comments used for review or publishing.
                                </p>
                            </div>

                            <div class="asset-form-grid">

                                <div class="asset-col-12">
                                    <label for="description" class="asset-label">
                                        Description
                                    </label>

                                    <textarea
                                        id="description"
                                        name="description"
                                        rows="4"
                                        class="asset-input asset-textarea @error('description') asset-invalid @enderror"
                                        placeholder="Write plan description">{{ old('description', $plan->description) }}</textarea>

                                    @error('description')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="asset-col-12">
                                    <label for="comments" class="asset-label">
                                        Comments
                                    </label>

                                    <textarea
                                        id="comments"
                                        name="comments"
                                        rows="3"
                                        class="asset-input asset-textarea @error('comments') asset-invalid @enderror"
                                        placeholder="Internal comments optional">{{ old('comments', $plan->comments) }}</textarea>

                                    @error('comments')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="ui-card">
                        <div class="form-section">

                            <div class="form-section__head">
                                <h5 class="form-section__title mb-1">Attachments</h5>
                                <p class="form-section__sub mb-0">
                                    Upload new supporting files and review existing attachments related to this plan.
                                </p>
                            </div>

                            <div class="upload-box">
                                <label for="attachments" class="asset-label">
                                    Upload Attachments
                                </label>

                                <input
                                    type="file"
                                    id="attachments"
                                    name="attachments[]"
                                    class="asset-input @error('attachments') asset-invalid @enderror @error('attachments.*') asset-invalid @enderror"
                                    multiple>

                                <div class="field-note mt-2">
                                    <small class="text-muted">
                                        You can upload multiple files. Existing attachments will remain available unless removed from another action.
                                    </small>
                                </div>

                                @error('attachments')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                @error('attachments.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

