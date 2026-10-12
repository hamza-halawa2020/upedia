        .report-shell {
            background: #f8f9fb;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 18px;
        }

        .report-box,
        .report-sidebar,
        .report-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
        }

        .report-box {
            padding: 18px;
        }

        .report-sidebar {
            padding: 14px;
            position: sticky;
            top: 90px;
        }

        .tab-link {
            width: 100%;
            text-align: left;
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #111827;
            border-radius: 14px;
            padding: 12px 14px;
            margin-bottom: 10px;
            font-weight: 600;
            transition: 0.2s ease;
        }

        .tab-link:hover {
            border-color: #cbd5e1;
        }

        .tab-link.active {
            background: #111827;
            border-color: #111827;
            color: #fff;
        }

        .tab-link:last-child {
            margin-bottom: 0;
        }

        .tab-pane-panel {
            display: none;
        }

        .tab-pane-panel.active {
            display: block;
        }

        .metric-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 16px;
        }

        .insight-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 16px;
        }

        .metric-tile,
        .insight-tile {
            display: block;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 16px;
            color: inherit;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .metric-tile:hover,
        .insight-tile:hover {
            color: inherit;
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }

        .metric-label,
        .insight-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #6b7280;
        }

        .metric-value {
            margin-top: 10px;
            font-size: clamp(1.8rem, 2vw, 2.6rem);
            font-weight: 700;
            color: #111827;
            line-height: 1.05;
        }

        .metric-meta,
        .insight-meta {
            display: block;
            margin-top: 10px;
            color: #475569;
        }

        .insight-title {
            margin-top: 10px;
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
        }

        .report-card .card-header {
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
        }

        .rank-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 12px 0;
            border-bottom: 1px solid #eef2f7;
            color: inherit;
            text-decoration: none;
        }

        .rank-row:last-child {
