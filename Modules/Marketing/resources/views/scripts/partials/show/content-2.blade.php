                            <span class="badge {{ $statusClass }} rounded-pill px-3 py-2 fw-semibold">
                                <i class="fas {{ $statusIcon }} me-1"></i> {{ ucfirst($scr->status ?? 'Pending') }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-bold text-uppercase mb-1">Visibility</label>
                        <div>
