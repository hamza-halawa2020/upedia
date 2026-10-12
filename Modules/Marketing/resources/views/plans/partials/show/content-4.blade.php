
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

        .asset-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .asset-actions form {
            margin: 0;
        }

        @media (max-width: 1200px) {
            .detail-item {
                grid-column: span 4 / span 4;
            }
        }

        @media (max-width: 992px) {
            .detail-item {
                grid-column: span 6 / span 6;
            }
        }

        @media (max-width: 768px) {
            .detail-item {
                grid-column: span 12 / span 12;
            }

            .asset-actions {
                justify-content: stretch;
            }

            .asset-actions .asset-btn,
            .asset-actions form {
                width: 100%;
            }

            .asset-actions .asset-btn {
                justify-content: center;
            }
        }
    </style>
