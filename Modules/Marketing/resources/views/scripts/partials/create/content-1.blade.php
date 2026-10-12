    <div class="container-fluid p-3 shadow-lg border-0 rounded-3">
        <div class="py-3">
            <div class="mb-0">Create New Script</div>
        </div>

        {{-- CRITICAL: Added enctype for file uploads --}}
        <form action="{{ route('scripts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="">

                {{-- Title & Category Name (Side-by-side) --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="category_name" class="form-label">Category Name <span
                                class="text-danger">*</span></label>
                        <input type="text" id="category_name" name="category_name"
                            class="form-control @error('category_name') is-invalid @enderror"
                            value="{{ old('category_name') }}" required>
                        @error('category_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Description (Full Width) --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea id="description" name="description"
                        class="form-control @error('description') is-invalid @enderror" rows="4"
                        required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Visibility, Department, and Keywords (Grid) --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="visibility" class="form-label">Visibility <span class="text-danger">*</span></label>
                        <select id="visibility" name="visibility"
                            class="form-select @error('visibility') is-invalid @enderror" required>
                            <option value="private" {{ old('visibility') == 'private' ? 'selected' : '' }}>Private</option>

                            <option value="public" {{ old('visibility') == 'public' ? 'selected' : '' }}>Public</option>
                        </select>
                        @error('visibility')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3 scripts-departments-field" id="departments-wrapper">
                        <label for="department_ids" class="form-label">
                            Departments <span class="text-danger">*</span>
                        </label>

                        <select id="department_ids" name="department_ids[]" multiple
                            class="form-select script-department-select @error('department_ids') is-invalid @enderror">
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ in_array($dept->id, old('department_ids', [])) ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_ids')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- @if($staff && $staff->jobTitle && $staff->jobTitle->slug == "marketing_manager")
                    <div class="col-md-6">
                        <label for="status" class="form-label fw-bold">Status</label>
                        <select id="status"
                            class="form-select @error('status') is-invalid @enderror"
                            name="status">
                            <option value="">Select Status</option>
                            @foreach (['unapproved','approved'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('-', ' ', $status)) }}
                            </option>
                            @endforeach
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    @endif -->


                    <div class="col-md-6 mb-3">
                        <label for="keywords" class="form-label">Keywords (optional)</label>
                        <input type="text" id="keywords" name="keywords"
                            class="form-control @error('keywords') is-invalid @enderror"
                            placeholder="marketing, design, hr..." value="{{ old('keywords') }}">
                        @error('keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-3">

                {{-- ATTACHMENTS FIELD --}}
                <div class="mb-3">
                    <label for="attachments" class="form-label"><i class="fas fa-paperclip me-1"></i> Attachments
                        (optional)</label>
                    <input type="file" id="attachments" name="attachments[]"
                        class="form-control @error('attachments') is-invalid @enderror" multiple>
                    <div class="form-text">Max 5 files. Allowed types: PDF, DOCX, JPG, PNG.</div>
                    @error('attachments')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    {{-- Note: If you want specific error messages per file, you would use a loop in the controller and
                    display errors for attachments.* --}}
                </div>

            </div>

            <div class="card-footer d-flex justify-content-between align-items-center">
                <x-table-action type="back" :url="url()->previous()" label="Cancel" class="rounded-pill" :icon="false" />
                <x-table-action type="create" buttonType="submit" label="Save Script" class="rounded-pill" :icon="false" />
            </div>
        </form>
    </div>


