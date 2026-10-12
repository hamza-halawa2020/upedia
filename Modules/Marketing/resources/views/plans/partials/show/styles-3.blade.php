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

        .details-grid {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 1rem;
        }

        .detail-item {
            grid-column: span 3 / span 3;
            border: 1px solid #eef2f7;
            border-radius: 16px;
            background: #f8fafc;
            padding: 1rem;
        }

        .detail-item__label {
            color: #64748b;
            font-size: 0.78rem !important;
            font-weight: 800;
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .detail-item__value {
            color: #111827;
            font-size: 0.95rem !important;
            font-weight: 600;
            line-height: 1.6;
            word-break: break-word;
        }

        .content-box {
            border: 1px solid #eef2f7;
            border-radius: 16px;
            background: #f8fafc;
            color: #111827;
            padding: 1rem;
            line-height: 1.7;
            font-size: 0.95rem !important;
        }

        .attachment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1rem;
        }

        .attachment-item {
            border: 1px solid #eef2f7;
            border-radius: 18px;
            background: #f8fafc;
            overflow: hidden;
            transition: 0.2s ease;
        }

        .attachment-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.08);
        }

        .attachment-preview {
            height: 210px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #eef2f7;
            overflow: hidden;
        }

        .attachment-preview a {
            display: block;
            width: 100%;
            height: 100%;
        }

        .attachment-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .attachment-preview iframe {
            width: 100%;
            height: 100%;
        }

        .file-icon {
            width: 68px;
            height: 68px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eef2ff;
            color: #4f46e5;
            font-size: 2rem !important;
        }

        .attachment-info {
            padding: 0.9rem;
        }

        .attachment-info__name {
            color: #111827;
            font-weight: 700;
            font-size: 0.9rem !important;
            margin-bottom: 0.75rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .attachment-view-btn {
            min-height: 34px;
            padding: 0.35rem 0.75rem;
            font-size: 0.82rem !important;
            border-radius: 999px;
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
            width: 52px;
            height: 52px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            color: #64748b;
            font-size: 1.6rem !important;
            flex-shrink: 0;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
        }
