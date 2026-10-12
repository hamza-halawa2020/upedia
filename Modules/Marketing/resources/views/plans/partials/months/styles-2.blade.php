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

        .months-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
        }

        .month-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border: 1px solid #eef2f7;
            border-radius: 20px;
            background: #f8fafc;
            color: #111827;
            text-decoration: none;
            transition: 0.2s ease;
            min-height: 92px;
        }

        .month-card:hover {
            transform: translateY(-2px);
            background: #fff;
            border-color: #dbe2ea;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
            color: #111827;
        }

        .month-card--active {
            background: #111827;
            border-color: #111827;
            color: #fff;
        }

        .month-card--active:hover {
            background: #111827;
            color: #fff;
        }

        .month-card__icon {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fff7ed;
            color: #f59e0b;
            font-size: 1.55rem;
            flex-shrink: 0;
        }

        .month-card--active .month-card__icon {
            background: rgba(255, 255, 255, 0.12);
            color: #fbbf24;
        }

        .month-card__content {
            min-width: 0;
            flex: 1;
        }

        .month-card__title {
            font-size: 1.05rem !important;
            font-weight: 800;
            line-height: 1.2;
        }

        .month-card__sub {
            margin-top: 0.25rem;
            font-size: 0.85rem !important;
            color: #64748b;
            font-weight: 600;
        }

        .month-card--active .month-card__sub {
            color: rgba(255, 255, 255, 0.7);
        }

        .month-card__arrow {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            color: #64748b;
            flex-shrink: 0;
            transition: 0.2s ease;
        }

        .month-card:hover .month-card__arrow {
            background: #111827;
            color: #fff;
        }

        .month-card--active .month-card__arrow {
            background: rgba(255, 255, 255, 0.14);
            color: #fff;
        }

        @media (max-width: 1200px) {
            .months-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 992px) {
            .months-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 576px) {
            .months-grid {
                grid-template-columns: 1fr;
            }

            .month-card {
                min-height: 82px;
            }
        }
    </style>
