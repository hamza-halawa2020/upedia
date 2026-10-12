
                                    <span class="ui-pill {{ $statusClass }}">
                                        {{ ucwords(str_replace('-', ' ', $plan->status)) }}
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div class="ui-card">
                    <div class="form-section">

                        <div class="form-section__head">
                            <h5 class="form-section__title mb-1">Description</h5>
                            <p class="form-section__sub mb-0">
                                Full marketing plan description and execution notes.
                            </p>
                        </div>

                        @if ($plan->description)
                            <div class="content-box">
                                {!! nl2br(e($plan->description)) !!}
                            </div>
                        @else
                            <div class="empty-state-box">
                                <div class="empty-state-box__icon">
                                    <iconify-icon icon="mdi:text-box-outline"></iconify-icon>
                                </div>
                                <div>
                                    <div class="empty-state-box__title">No description</div>
                                    <div class="empty-state-box__text">
                                        No description was added to this marketing plan.
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- Comments --}}
                <div class="ui-card">
                    <div class="form-section">

                        <div class="form-section__head">
                            <h5 class="form-section__title mb-1">Internal Comments</h5>
                            <p class="form-section__sub mb-0">
                                Internal notes used by the team during review, publishing, or follow-up.
                            </p>
                        </div>

                        @if ($plan->comments)
                            <div class="content-box">
                                {!! nl2br(e($plan->comments)) !!}
                            </div>
                        @else
                            <div class="empty-state-box">
                                <div class="empty-state-box__icon">
                                    <iconify-icon icon="mdi:comment-text-outline"></iconify-icon>
                                </div>
                                <div>
                                    <div class="empty-state-box__title">No comments</div>
                                    <div class="empty-state-box__text">
                                        No internal comments are available for this plan.
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- Attachments --}}
                <div class="ui-card">
                    <div class="form-section">

                        <div class="form-section__head">
                            <h5 class="form-section__title mb-1">Attachments</h5>
                            <p class="form-section__sub mb-0">
                                Uploaded files, images, PDFs, designs, scripts, or supporting references.
                            </p>
                        </div>

                        @if ($plan->attachments && $plan->attachments->count() > 0)
                            <div class="attachment-grid">
                                @foreach ($plan->attachments as $file)
                                    @php
                                        $extension = strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION));
                                        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'jfif']);
                                        $isPdf = $extension === 'pdf';
                                    @endphp

                                    <div class="attachment-item">
                                        <div class="attachment-preview">
                                            @if ($isImage)
                                                <a href="{{ asset($file->file_path) }}" target="_blank">
                                                    <img src="{{ asset($file->file_path) }}" alt="Attachment">
                                                </a>
                                            @elseif ($isPdf)
                                                <iframe src="{{ asset($file->file_path) }}" frameborder="0"></iframe>
                                            @else
                                                <div class="file-icon">
                                                    <iconify-icon icon="mdi:paperclip"></iconify-icon>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="attachment-info">
                                            <div class="attachment-info__name" title="{{ basename($file->file_path) }}">
                                                {{ basename($file->file_path) }}
                                            </div>

                                            <a href="{{ asset($file->file_path) }}" target="_blank" class="asset-btn asset-btn--secondary attachment-view-btn">
                                                <iconify-icon icon="lucide:eye"></iconify-icon>
                                                <span>View</span>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state-box">
                                <div class="empty-state-box__icon">
                                    <iconify-icon icon="mdi:paperclip"></iconify-icon>
                                </div>
                                <div>
                                    <div class="empty-state-box__title">No attachments</div>
                                    <div class="empty-state-box__text">
                                        No files were uploaded for this marketing plan.
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- Actions --}}
                <div class="asset-actions">
                    <a href="{{ route('plans.index') }}" class="asset-btn asset-btn--secondary">
                        Back to List
                    </a>

                    <form action="{{ route('plans.destroy', $plan->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this plan?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="asset-btn asset-btn--danger">
                            <iconify-icon icon="fluent:delete-24-regular"></iconify-icon>
                            <span>Delete</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
