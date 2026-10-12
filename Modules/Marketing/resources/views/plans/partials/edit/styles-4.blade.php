    <style>
        .form-section__head {
            margin-bottom: 1rem;
            padding-bottom: 0.9rem;
            border-bottom: 1px solid #eef2f7;
        }

        .form-section__title {
            font-size: 1rem !important;
            font-weight: 700;
            color: #111827;
        }

        .form-section__sub {
            color: #6b7280;
            font-size: 0.92rem !important;
        }

        .asset-form-grid {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 1rem;
        }

        .asset-col-12 {
            grid-column: span 12 / span 12;
        }

        .asset-col-6 {
            grid-column: span 6 / span 6;
        }

        .asset-label {
            display: inline-block;
            margin-bottom: 0.45rem;
            font-weight: 600;
            color: #374151;
            font-size: 0.92rem !important;
        }

        .asset-input,
        .asset-select {
            width: 100%;
            min-height: 44px;
            border: 1px solid #dbe2ea;
            border-radius: 12px;
            padding: 0.7rem 0.9rem;
            background: #fff;
            color: #111827;
            transition: 0.2s ease;
            font-size: 0.95rem !important;
        }

        .asset-input:focus,
        .asset-select:focus {
            outline: none;
            border-color: #b8c4d6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.08);
        }

        .asset-textarea {
            resize: vertical;
            min-height: 110px;
        }

        .asset-invalid {
            border-color: #dc3545 !important;
        }

        .field-note {
            color: #6b7280;
            font-size: 0.85rem !important;
        }

        .upload-box {
            padding: 1rem;
            border: 1px dashed #dbe2ea;
            border-radius: 16px;
            background: #f8fafc;
        }

        .existing-attachments {
            padding: 1rem;
            border: 1px solid #eef2f7;
            border-radius: 16px;
            background: #fff;
        }

        .existing-attachments__title {
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.9rem;
            font-size: 1rem !important;
        }

        .attachment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1rem;
        }

        .attachment-item {
            display: block;
            border: 1px solid #eef2f7;
            border-radius: 16px;
            background: #f8fafc;
            text-decoration: none;
            overflow: hidden;
            transition: 0.2s ease;
        }

        .attachment-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.08);
        }

        .attachment-preview {
            height: 150px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #eef2f7;
        }

        .attachment-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .file-icon {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eef2ff;
            color: #4f46e5;
            font-size: 2rem !important;
        }

        .file-icon--pdf {
            background: #fee2e2;
            color: #dc2626;
        }

        .attachment-info {
            padding: 0.85rem;
        }

        .attachment-info__name {
            color: #111827;
            font-weight: 700;
            font-size: 0.9rem !important;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
