<div class="container-fluid mt-3">
    {{-- Header Section --}}
    <div class="row align-items-center mb-3">
        <div class="col-md-8">
          
            <div class="fw-bold mb-0">{{ $scr->title }}</div>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('scripts.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
            @can('marketing_scripts_edit')
            <a href="{{ route('scripts.edit', $scr->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 ms-2">
                <i class="fas fa-edit me-1"></i> Edit Script
            </a>
            @endcan
        </div>
    </div>

    <div class="row">
        {{-- Main Content Section --}}
        <div class="col-lg-8">
            {{-- Overview --}}
            <div class="p-3 border-0 shadow-sm rounded-4 mb-3">
                <div class="p-3">
                    <div class="fw-bold mb-3">
                        <i class="fas fa-info me-2"></i> Script Description
                    </div>
                    <div class="text-secondary lh-lg mb-3" style="font-size: 1.05rem;">
                        {!! nl2br(e($scr->description)) !!}
                    </div>

                    @if($scr->keywords)
                    <div class="mt-3 pt-3 border-top">
                        <div class="fw-bold mb-3">
                            <i class="fas fa-tags me-2"></i> Keywords
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(explode(',', $scr->keywords) as $keyword)
                                <span class="border border-primary-subtle px-3 py-2 rounded-pill">
                                    {{ trim($keyword) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Attachments Section --}}
            <div class="p-3 border-0 shadow-sm rounded-4 mb-3">
                <div class="p-3">
                    <div class="fw-bold mb-3">
                        <i class="fas fa-paperclip me-2"></i> Attachments
                    </div>

                    @if($scr->attachments && $scr->attachments->count())
                        <div class="row g-3">
                            @foreach($scr->attachments as $file)
                                @php
                                    $path = route('attachments.show', $file->id);
                                    $extension = strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION));
                                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'jfif']);
                                @endphp

                                <div class="col-sm-6 {{ $isImage ? 'col-md-4' : 'col-md-12' }}">
                                    @if($isImage)
                                        <div class="position-relative group rounded-3 overflow-hidden border">
                                            <a href="{{ $path }}" target="_blank" class="d-block">
                                                <img src="{{ $path }}" alt="Attachment" class="img-fluid w-100" style="height: 150px; object-fit: cover;">
                                                <div class="position-absolute bottom-0 start-0 w-100 p-2 text-center small">
                                                    <i class="fas fa-search-plus"></i> View Preview
                                                </div>
                                            </a>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center p-3 rounded-3 border">
                                            <div class="flex-shrink-0 p-2 rounded border">
                                                <i class="fas fa-file-alt fa-2x"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3 overflow-hidden">
                                                <div class="fw-semibold text-truncate small">{{ basename($file->file_path) }}</div>
                                                <div class="small text-uppercase" style="font-size: 0.7rem;">{{ $extension }} file</div>
                                            </div>
                                            <div class="ms-2">
                                                <a href="{{ $path }}" target="_blank" class="btn btn-sm rounded">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3 rounded-4 border border-dashed">
                            <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                            <p class="mb-0">No attachments uploaded for this script.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar Section --}}
        <div class="col-lg-4">
            {{-- Quick Details --}}
            <div class="p-3 border-0 shadow-sm rounded-4 mb-3 overflow-hidden">
                    <div class="mb-0 fw-bold"><i class="fas fa-bolt me-2"></i> Script Metadata</div>
                <div class="p-3">
                    <div class="mb-3">
                        <label class="small fw-bold text-uppercase mb-1">Category</label>
                        <div class="fw-bold" style="font-size: 1.1rem;">
                            <i class="fas fa-folder-open me-2"></i> {{ $scr->category_name }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-bold text-uppercase mb-1">Status</label>
                        <div>
