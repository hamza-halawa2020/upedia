    <style>
        .select2-selection--single,
        .select2-selection--multiple {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            width: 290px !important;
        }

        .complain-filter-card {
            border-radius: 20px 20px 0 0 !important;
            margin-bottom: 0 !important;
        }

        .complain-filter-header {
            min-width: 0;
        }

        .complain-filter-header .table-controls-form {
            flex: 1 1 680px;
        }

        .complain-table-card {
            border-radius: 0 0 20px 20px !important;
            overflow: hidden;
        }

        .complain-actions {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.55rem;
        }

        .delete-action-btn {
            border: none;
            background: transparent;
            padding: 0;
            line-height: 1;
        }

        .complain-lead-btn {
            min-height: 34px;
            padding: 0.35rem 0.75rem;
            font-size: 0.78rem;
            border-radius: 999px;
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

        @media (max-width: 768px) {
            .complain-filter-header {
                align-items: stretch !important;
            }

            .complain-filter-header .table-controls-form {
                flex-basis: 100%;
            }

            .select2-selection--single,
            .select2-selection--multiple {
                width: 100% !important;
            }

            .pagination-shell {
                justify-content: center;
            }
        }
    </style>
