  <!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('tabs.store') }}" method="POST">
                @csrf
                @method('POST')
                <div class="modal-header">
                    <div class="modal-title">Add Parent Tab</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="label" class="form-label">Label</label>
                        <input type="text" class="form-control" name="label" required>
                    </div>


                    <div class="mb-3">
                        <label for="icon" class="form-label">Icon</label>
                        <input type="hidden" class="form-control selected-icon"
                            name="icon" value="" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Choose Icon</label>
                        <div class="icon-grid d-flex flex-wrap gap-2" data-modal-id="createModal">
                            <div class="text-center w-100 p-3">
                                <div class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="mt-2">Loading icons...</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="order" class="form-label">Order</label>
                        <input type="number" class="form-control" name="order" value="">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Systems</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach (['settings', 'hr', 'crm', 'academy', 'finance', 'retention', 'it', 'marketing'] as $sys)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="systems[]" value="{{ $sys }}" id="sys_{{ $sys }}">
                                    <label class="form-check-label" for="sys_{{ $sys }}">
                                        {{ strtoupper($sys) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
