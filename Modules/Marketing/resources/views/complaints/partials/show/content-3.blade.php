
                                    <span class="ui-pill {{ $statusClass }}">
                                        {{ ucwords(str_replace('_', ' ', $complain->status)) }}
                                    </span>
                                </div>
                            </div>

                            @if ($complain->status === 'solved' && $complain->solver)
                                <div class="detail-item">
                                    <div class="detail-item__label">Solved By</div>
                                    <div class="detail-item__value">
                                        {{ $complain->solver->full_name }}
                                    </div>
                                </div>
                            @endif

                            <div class="detail-item detail-item--wide">
                                <div class="detail-item__label">Note</div>
                                <div class="detail-item__value">
                                    {{ $complain->note ?: '-' }}
                                </div>
                            </div>

                            <div class="detail-item detail-item--wide">
                                <div class="detail-item__label">Moderator Note</div>
                                <div class="detail-item__value">
                                    {{ $complain->moderator_note ?: '-' }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="ui-card">
                    <div class="form-section">
                        <div class="form-section__head">
                            <h5 class="form-section__title mb-1">Attachments</h5>
                            <p class="form-section__sub mb-0">
                                Files and uploaded assets related to this complaint.
                            </p>
                        </div>

                        @if ($complain->attachments->count())
                            <div class="attachment-grid">
                                @foreach ($complain->attachments as $file)
                                    @php
                                        $extension = strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION));
                                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'jfif'];
                                        $isImage = in_array($extension, $imageExtensions);
                                        $isPdf = $extension === 'pdf';
                                    @endphp

                                    <a href="{{ route('attachments.show', $file->id) }}" target="_blank" class="attachment-item">
                                        <div class="attachment-preview">
                                            @if ($isImage)
                                                <img src="{{ route('attachments.show', $file->id) }}" alt="Attachment">
                                            @elseif ($isPdf)
                                                <div class="file-icon file-icon--pdf">
                                                    <iconify-icon icon="mdi:file-pdf-box"></iconify-icon>
                                                </div>
                                            @else
                                                <div class="file-icon">
                                                    <iconify-icon icon="mdi:paperclip"></iconify-icon>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="attachment-info">
                                            <div class="attachment-info__name">
                                                {{ basename($file->file_path) }}
                                            </div>
                                            <div class="attachment-info__action">
                                                View Attachment
                                            </div>
                                        </div>
                                    </a>
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
                                        There are no uploaded files attached to this complaint yet.
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="asset-actions">
                    <a href="{{ url()->previous() }}" class="asset-btn asset-btn--secondary">
                        Back
                    </a>
                </div>

            </div>
        </div>
    </div>
