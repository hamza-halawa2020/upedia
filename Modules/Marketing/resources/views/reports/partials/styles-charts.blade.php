            border-bottom: 0;
        }

        .rank-row:hover {
            color: inherit;
        }

        .rank-bar {
            height: 8px;
            border-radius: 999px;
            background: #e5e7eb;
            overflow: hidden;
        }

        .rank-bar > span {
            display: block;
            height: 100%;
            background: #475569;
        }

        .report-toolbar {
            width: 100%;
            max-width: 560px;
        }

        .quick-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .chart-wrap {
            position: relative;
            width: 100%;
            min-height: 280px;
        }

        .section-head {
            margin-bottom: 16px;
        }

        .section-head p {
            color: #475569;
        }

        .status-stack .rank-row {
            padding: 14px 0;
        }

        .status-stack .badge {
            min-width: 72px;
            text-align: center;
        }

        @media (max-width: 1399.98px) {
            .metric-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 991.98px) {
            .report-sidebar {
                position: static;
            }

            .metric-grid,
            .insight-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {
            .report-shell {
                padding: 14px;
            }

            .metric-grid,
            .insight-grid {
                grid-template-columns: 1fr;
            }

            .rank-row {
                flex-wrap: wrap;
                align-items: flex-start;
            }

            .report-toolbar {
                max-width: 100%;
            }

            .chart-wrap {
                min-height: 250px;
            }
        }
