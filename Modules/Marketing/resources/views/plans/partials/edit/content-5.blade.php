
        .attachment-info__action {
            color: #64748b;
            font-size: 0.82rem !important;
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
