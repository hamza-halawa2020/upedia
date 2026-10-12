    <style>
        .details-grid {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 1rem;
        }

        .detail-item {
            grid-column: span 4 / span 4;
            border: 1px solid #eef2f7;
            border-radius: 16px;
            background: #f8fafc;
            padding: 1rem;
        }

        .detail-item--wide {
            grid-column: span 6 / span 6;
        }

        .detail-item__label {
            color: #64748b;
            font-size: 0.82rem;
            font-weight: 700;
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .detail-item__value {
            color: #111827;
            font-size: 0.95rem;
            font-weight: 600;
            line-height: 1.6;
            word-break: break-word;
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
            height: 160px;
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
            font-size: 2rem;
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
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .attachment-info__action {
            color: #64748b;
            font-size: 0.82rem;
        }

        .empty-state-box {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem;
            border: 1px dashed #dbe2ea;
            border-radius: 16px;
            background: #f8fafc;
        }

        .empty-state-box__icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            color: #64748b;
            font-size: 1.45rem;
            flex-shrink: 0;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
        }

        .empty-state-box__title {
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.2rem;
        }

        .empty-state-box__text {
            color: #6b7280;
            font-size: 0.92rem;
        }

        .asset-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        @media (max-width: 992px) {
            .detail-item,
            .detail-item--wide {
                grid-column: span 6 / span 6;
            }
        }

        @media (max-width: 768px) {
            .detail-item,
            .detail-item--wide {
                grid-column: span 12 / span 12;
            }
