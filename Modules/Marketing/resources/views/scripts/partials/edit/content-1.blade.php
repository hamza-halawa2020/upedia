    <div class="p-3 shadow-lg border-0 rounded-3">
        <div class="py-3">
            <div class="mb-0">Edit Script</div>
        </div>

        <form action="{{ route('scripts.update', $scr->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="">

                {{-- Title & Category --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $scr->title) }}" required>
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="category_name" class="form-label">Category Name <span
                                class="text-danger">*</span></label>
                        <input type="text" id="category_name" name="category_name"
                            class="form-control @error('category_name') is-invalid @enderror"
                            value="{{ old('category_name', $scr->category_name) }}" required>
                        @error('category_name')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea id="description" name="description" rows="4"
                        class="form-control @error('description') is-invalid @enderror"
                        required>{{ old('description', $scr->description) }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Visibility / Department --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="visibility" class="form-label">Visibility <span class="text-danger">*</span></label>
                        <select id="visibility" name="visibility"
                            class="form-select @error('visibility') is-invalid @enderror" required>
                            <option value="public" {{ old('visibility', $scr->visibility) == 'public' ? 'selected' : '' }}>
                                Public</option>
                            <option value="private" {{ old('visibility', $scr->visibility) == 'private' ? 'selected' : '' }}>
                                Private</option>
                        </select>
                        @error('visibility')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3 scripts-departments-field" id="departments-wrapper">
                        <label for="department_ids" class="form-label">
                            Departments <span class="text-danger">*</span>
                        </label>

                        <select id="department_ids" name="department_ids[]" multiple
                            class="form-select script-department-select @error('department_ids') is-invalid @enderror"
                            required>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ collect(old('department_ids', $scr->departments->pluck('id')->toArray()))->contains($dept->id) ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('department_ids')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status (Marketing Manager only) --}}
                    @if($staff && $staff->jobTitle && $staff->jobTitle->slug === 'marketing_manager' || auth()->user()->hasRole('Super admin'))
                        <div class="mb-3 col-md-6">
                            <label for="status" class="form-label fw-bold">Status</label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                                @foreach(['unapproved', 'approved'] as $status)
                                    <option value="{{ $status }}" {{ old('status', $scr->status) == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    @endif

                    {{-- Keywords --}}
                    <div class="mb-3 col-md-6">
                        <label for="keywords" class="form-label">Keywords</label>
                        <input type="text" id="keywords" name="keywords"
                            class="form-control @error('keywords') is-invalid @enderror"
                            value="{{ old('keywords', $scr->keywords) }}" placeholder="marketing, design, hr">
                        @error('keywords')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <hr>

                {{-- Existing Attachments --}}
                <div class="mb-3">
                    <div class="text-muted">
                        <i class="fas fa-paperclip me-1"></i> Existing Attachments
                    </div>

                    @if($scr->attachments && $scr->attachments->count())
                        <div class="row">
                            @foreach($scr->attachments as $file)
                                @php
                                    $ext = strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION));
                                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                @endphp

                                <div class="col-md-4 mb-3">
                                    <div class="border rounded p-2 text-center">
                                        @if($isImage)
                                            <img src="{{ route('attachments.show', $file->id) }}" class="img-fluid rounded mb-2"
                                                style="max-height: 150px;">
                                        @else
                                            <i class="fas fa-file fa-2x mb-2"></i>
                                        @endif

                                        <div class="small text-truncate">
                                            {{ basename($file->file_path) }}
                                        </div>

                                        <a href="{{ route('attachments.show', $file->id) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary mt-2">
                                            View
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No attachments uploaded.</p>
                    @endif
                </div>

                {{-- Add New Attachments --}}
                <div class="mb-3">
                    <label for="attachments" class="form-label">Add New Attachments</label>
                    <input type="file" id="attachments" name="attachments[]" multiple
                        class="form-control @error('attachments') is-invalid @enderror">
                    @error('attachments')
                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

            </div>

            <div class="d-flex justify-content-between">
                <x-table-action type="back" :url="route('scripts.show', $scr->id)" label="Cancel" class="rounded-pill"
                    :icon="false" />
                <x-table-action type="create" buttonType="submit" label="Update Script" class="rounded-pill"
                    :icon="false" />
            </div>
        </form>
    </div>
