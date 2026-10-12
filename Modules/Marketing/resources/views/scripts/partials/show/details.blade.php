                            <span class="badge {{ $visibilityClass }} rounded-pill px-3 py-2 border border-{{ $scr->visibility === 'public' ? 'success' : 'secondary' }}-subtle">
                                <i class="fas {{ $visibilityIcon }} me-1"></i> {{ ucfirst($scr->visibility) }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-bold text-uppercase mb-1">Departments</label>
                        <div class="d-flex flex-wrap gap-2 mt-1">
                            @forelse ($scr->departments as $dept)
                                <span class="border px-3 py-2 rounded-pill small">
                                    <i class="fas fa-building me-1"></i> {{ $dept->name }}
                                </span>
                            @empty
                                <span class="small italic">Not assigned to any department</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Audit/Time --}}
            <div class="p-3 border-0 shadow-sm rounded-4">
                <div class="p-3">
                    <div class="fw-bold mb-3 border-bottom pb-2">
                        <i class="fas fa-history me-2"></i> Timeline & Activity
                    </div>
                    
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-primary-subtle p-2 rounded text-primary">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div class="ms-3">
                            <p class="small mb-0">Created By</p>
                            <p class="mb-0 fw-bold">{{ optional($scr->creator)->full_name ?? 'System User' }}</p>
                        </div>
                    </div>

                    @if($scr->status === 'approved' && $scr->approver)
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-info-subtle p-2 rounded text-info">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="ms-3">
                            <p class="small mb-0">Approved By</p>
                            <p class="mb-0 fw-bold">{{ $scr->approver->full_name }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-success-subtle p-2 rounded text-success">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="ms-3">
                            <p class="small mb-0">Date Created</p>
                            <p class="mb-0 fw-bold">{{ $scr->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-info-subtle p-2 rounded text-info">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="ms-3">
                            <p class="small mb-0">Last Updated</p>
                            <p class="mb-0 fw-bold">{{ $scr->updated_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .breadcrumb-item + .breadcrumb-item::before {
        content: "\f054";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        font-size: 0.7rem;
        color: #adb5bd;
    }
    .group:hover img {
        filter: brightness(0.7);
        transition: 0.3s ease;
    }
    .bg-success-subtle { background-color: #d1e7dd; }
    .bg-warning-subtle { background-color: #fff3cd; }
    .bg-primary-subtle { background-color: #cfe2ff; }
    .bg-info-subtle { background-color: #cff4fc; }
    .bg-secondary-subtle { background-color: #e2e3e5; }
    .text-primary-subtle { color: #084298; }
</style>
