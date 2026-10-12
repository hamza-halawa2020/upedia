    @include('components.alert')

    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="space-y-4">

                <x-page-title
                    title="Marketing Plan Details"
                    description="Review marketing plan information, publishing schedule, content details, comments, attachments, and available actions.">

                    <a href="{{ route('plans.index') }}" class="asset-btn asset-btn--secondary">
                        <iconify-icon icon="ion:arrow-back-outline"></iconify-icon>
                        <span>Back to List</span>
                    </a>

                </x-page-title>

                {{-- Basic Information --}}
                <div class="ui-card">
                    <div class="form-section">

                        <div class="form-section__head">
                            <h5 class="form-section__title mb-1">Basic Information</h5>
                            <p class="form-section__sub mb-0">
                                Main plan data including name, subject, month, publishing date, platform, type, and status.
                            </p>
                        </div>

                        <div class="details-grid">

                            <div class="detail-item">
                                <div class="detail-item__label">Plan Name</div>
                                <div class="detail-item__value">
                                    {{ $plan->name ?: '-' }}
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-item__label">Subject</div>
                                <div class="detail-item__value">
                                    {{ $plan->subject ?: '-' }}
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-item__label">Month</div>
                                <div class="detail-item__value">
                                    {{ $plan->month ?: '-' }}
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-item__label">Publish Date</div>
                                <div class="detail-item__value">
                                    {{ $plan->publish_date ?: '-' }}
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-item__label">Publish Time</div>
                                <div class="detail-item__value">
                                    {{ $plan->publish_time ?: '-' }}
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-item__label">Platform</div>
                                <div class="detail-item__value">
                                    <span class="ui-pill ui-pill--info">
                                        {{ ucfirst($plan->platform) }}
                                    </span>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-item__label">Type</div>
                                <div class="detail-item__value">
                                    <span class="ui-pill ui-pill--neutral">
                                        {{ ucwords(str_replace('_', ' ', $plan->type)) }}
                                    </span>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-item__label">Status</div>
                                <div class="detail-item__value">
