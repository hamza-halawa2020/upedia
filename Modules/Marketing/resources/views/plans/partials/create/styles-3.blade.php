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

        .asset-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 0.75rem;
            margin-top: 1.25rem;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .asset-col-6 {
                grid-column: span 12 / span 12;
            }

            .asset-actions {
                justify-content: stretch;
            }

            .asset-actions .asset-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
