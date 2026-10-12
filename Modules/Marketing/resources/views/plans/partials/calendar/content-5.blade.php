
        .fc-event-status-under-review {
            background-color: #0ea5e9 !important;
            border-color: #0ea5e9 !important;
            color: white !important;
        }

        .fc-event-status-ready-to-publish {
            background-color: #4f46e5 !important;
            border-color: #4f46e5 !important;
            color: white !important;
        }

        .fc-event-status-not-approved {
            background-color: #dc2626 !important;
            border-color: #dc2626 !important;
            color: white !important;
        }

        .calendar-modal-dialog {
            max-width: 720px;
        }

        .calendar-modal-header {
            padding: 1.25rem 1.25rem 0.75rem;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 1rem;
        }

        .detail-item {
            grid-column: span 6 / span 6;
            border: 1px solid #eef2f7;
            border-radius: 16px;
            background: #f8fafc;
            padding: 1rem;
        }

        .detail-item--wide {
            grid-column: span 12 / span 12;
        }

        .detail-item__label {
            color: #64748b;
            font-size: 0.78rem;
            font-weight: 800;
            margin-bottom: 0.35rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .detail-item__value {
            color: #111827;
            font-size: 0.94rem !important;
            font-weight: 600;
            line-height: 1.6;
            word-break: break-word;
        }

        @media (max-width: 992px) {
            .calendar-filter-grid {
                grid-template-columns: 1fr;
            }

            .fc .fc-toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .fc .fc-toolbar-chunk {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
            }
        }

        @media (max-width: 768px) {
            .detail-item,
            .detail-item--wide {
                grid-column: span 12 / span 12;
            }

            .calendar-filter-actions {
                justify-content: stretch;
            }

            .calendar-filter-actions .asset-btn,
            .calendar-filter-actions .ui-pill {
                width: 100%;
                justify-content: center;
                text-align: center;
            }
        }
    </style>
