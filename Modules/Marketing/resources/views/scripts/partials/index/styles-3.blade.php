    <style>
        .scripts-filter-card {
            border-radius: 20px 20px 0 0 !important;
            margin-bottom: 0 !important;
        }

        .scripts-table-card {
            border-radius: 0 0 20px 20px !important;
            overflow: hidden;
        }

        .script-meta {
            font-size: 0.78rem !important;
            font-weight: 700;
        }

        .script-departments {
            display: flex;
            flex-wrap: wrap;
            gap: 0.35rem;
            justify-content: center;
            max-width: 260px;
        }

        .script-department-chip {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.55rem;
            border-radius: 999px;
            border: 1px solid #dbe2ea;
            background: #f8fafc;
            color: #334155;
            font-size: 0.72rem !important;
            font-weight: 700;
            white-space: nowrap;
        }

        .pagination-shell {
            display: flex;
            justify-content: flex-end;
            margin-top: 1rem;
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

        .empty-state-box__title {
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.2rem;
            font-size: 1rem !important;
        }

        .empty-state-box__text {
            color: #6b7280;
            font-size: 0.92rem !important;
        }

        @media (max-width: 768px) {
            .ui-card__header .d-flex {
                flex-wrap: wrap !important;
            }

            .pagination-shell {
                justify-content: center;
            }

            .empty-state-box {
                align-items: flex-start;
            }

            .script-departments {
                max-width: 100%;
            }
        }
    </style>
