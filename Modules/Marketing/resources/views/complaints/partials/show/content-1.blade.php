    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="space-y-4">

                <x-page-title
                    title="Complain Details"
                    description="Review full complaint information, client data, platform, priority, status, notes, and attachments.">

                    <a href="{{ url()->previous() }}" class="asset-btn asset-btn--secondary">
                        <iconify-icon icon="ion:arrow-back-outline"></iconify-icon>
                        <span>Back</span>
                    </a>

                </x-page-title>

                <div class="ui-card">
                    <div class="form-section">
                        <div class="form-section__head">
                            <h5 class="form-section__title mb-1">Main Information</h5>
                            <p class="form-section__sub mb-0">
                                Complaint source, client details, assigned sales member, and resolution status.
                            </p>
                        </div>

                        <div class="details-grid">

                            <div class="detail-item">
                                <div class="detail-item__label">Client Name</div>
                                <div class="detail-item__value">
                                    {{ $complain->client_name ?: '-' }}
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-item__label">Client Number</div>
                                <div class="detail-item__value">
                                    {{ $complain->client_number ?: '-' }}
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-item__label">Date</div>
                                <div class="detail-item__value">
                                    {{ $complain->date ?: '-' }}
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-item__label">Platform</div>
                                <div class="detail-item__value">
                                    <span class="ui-pill ui-pill--info">
                                        {{ ucfirst($complain->platform) }}
                                    </span>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-item__label">Assigned Agent</div>
                                <div class="detail-item__value">
                                    {{ trim(($complain->sales?->first_name ?? '') . ' ' . ($complain->sales?->last_name ?? '')) ?: '-' }}
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-item__label">Department</div>
                                <div class="detail-item__value">
                                    <span class="ui-pill ui-pill--neutral">
                                        {{ ucwords($complain->department ?? 'sales') }}
                                    </span>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-item__label">Case Type</div>
                                <div class="detail-item__value">
                                    <span class="ui-pill ui-pill--info">
                                        {{ ucwords(str_replace('_', ' ', $complain->case_type ?? 'complaint')) }}
                                    </span>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-item__label">System</div>
                                <div class="detail-item__value">
                                    {{ $complain->system ?: '-' }}
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-item__label">Priority</div>
                                <div class="detail-item__value">
