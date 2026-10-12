                            @if (!empty($plan->attachments) && $plan->attachments->count() > 0)
                                <div class="existing-attachments mt-4">
                                    <div class="existing-attachments__title">
                                        Existing Attachments
                                    </div>

                                    <div class="attachment-grid">
                                        @foreach ($plan->attachments as $file)
                                            @php
                                                $path = $file->file_path;
                                                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                $isPdf = $ext === 'pdf';
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
                                                    <div class="attachment-info__name" title="{{ basename($file->file_path) }}">
                                                        {{ basename($file->file_path) }}
                                                    </div>
                                                    <div class="attachment-info__action">
                                                        View Attachment
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="asset-actions">
                                <a href="{{ route('plans.index') }}" class="asset-btn asset-btn--secondary">
                                    Cancel
                                </a>

                                <button type="submit" class="asset-btn asset-btn--primary">
                                    Update Plan
                                </button>
                            </div>

                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
