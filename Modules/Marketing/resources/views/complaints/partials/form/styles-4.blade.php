    <style>
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
            font-size: 0.92rem;
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
            font-size: 0.85rem;
        }

        .phone-lookup-wrap {
            position: relative;
        }

        .phone-lookup-results {
            position: absolute;
            z-index: 30;
            top: calc(100% + 6px);
            left: 0;
            right: 0;
            max-height: 260px;
            overflow-y: auto;
            border: 1px solid #dbe2ea;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.12);
        }

        .phone-lookup-option {
            width: 100%;
            border: 0;
            background: transparent;
            padding: 0.75rem 0.9rem;
            text-align: left;
            display: flex;
            justify-content: space-between;
            gap: 0.75rem;
            cursor: pointer;
        }

        .phone-lookup-option:hover,
        .phone-lookup-option:focus {
            background: #f8fafc;
            outline: none;
        }

        .phone-lookup-empty {
            padding: 0.75rem 0.9rem;
            color: #64748b;
            font-size: 0.9rem;
        }

        .phone-lookup-name {
            display: block;
            color: #111827;
            font-weight: 700;
            line-height: 1.3;
        }

        .phone-lookup-meta {
            display: block;
            color: #64748b;
            font-size: 0.82rem;
            line-height: 1.4;
        }

        .phone-lookup-source {
            align-self: flex-start;
            border-radius: 999px;
            background: #eef2ff;
            color: #3730a3;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.25rem 0.55rem;
            white-space: nowrap;
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
            margin-bottom: 0.75rem;
        }

        .attachment-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .attachment-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 0.75rem;
            border-radius: 999px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            color: #334155;
            font-size: 0.85rem;
            text-decoration: none;
            transition: 0.2s ease;
        }
