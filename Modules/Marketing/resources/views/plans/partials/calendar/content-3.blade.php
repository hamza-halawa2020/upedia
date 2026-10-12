
                                    @foreach ($platforms as $platform)
                                        <label class="filter-checkbox">
                                            <input type="checkbox" value="{{ $platform }}" data-filter-type="platform">
                                            <span>{{ ucwords($platform) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                        <div class="calendar-filter-actions">
                            <span id="selectedCount" class="ui-pill ui-pill--info">
                                0 selected
                            </span>

                            <button type="button" class="asset-btn asset-btn--secondary" onclick="clearAllFilters()">
                                Clear Filters
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Calendar --}}
                <div class="ui-card calendar-card">
                    <div class="form-section">
                        <div class="form-section__head">
                            <h5 class="form-section__title mb-1">Plans Calendar</h5>
                            <p class="form-section__sub mb-0">
                                Click any calendar item to preview its full marketing plan details.
                            </p>
                        </div>

                        <div class="calendar-shell">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Event Details Modal --}}
    <div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered calendar-modal-dialog">
            <div class="modal-content border-0 shadow-lg rounded-4 calendar-modal">

                <div class="modal-header border-bottom-0 calendar-modal-header">
                    <div>
                        <h5 class="modal-title mb-1" id="eventModalTitle">Plan Details</h5>
                        <small class="text-muted">Review selected marketing plan information.</small>
                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body pt-0">
                    <div class="details-grid calendar-details-grid">

                        <div class="detail-item detail-item--wide">
                            <div class="detail-item__label">Plan Name</div>
                            <div class="detail-item__value" id="modal-plan-name">-</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-item__label">Created By</div>
                            <div class="detail-item__value" id="modal-staff">-</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-item__label">Platform</div>
                            <div class="detail-item__value" id="modal-platform">-</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-item__label">Type</div>
                            <div class="detail-item__value" id="modal-type">-</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-item__label">Status</div>
                            <div class="detail-item__value" id="modal-status">-</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-item__label">Published</div>
                            <div class="detail-item__value" id="modal-published">-</div>
                        </div>

                        <div class="detail-item detail-item--wide">
                            <div class="detail-item__label">Subject</div>
                            <div class="detail-item__value" id="modal-subject">-</div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="asset-btn asset-btn--secondary" data-bs-dismiss="modal">
                        Close
                    </button>

                    <a href="#" id="modal-view-link" class="asset-btn asset-btn--primary">
                        <iconify-icon icon="lucide:eye"></iconify-icon>
                        <span>View Full Plan</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
