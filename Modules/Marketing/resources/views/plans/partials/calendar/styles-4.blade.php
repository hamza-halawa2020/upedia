    <style>
        .calendar-filter-card,
        .calendar-card {
            border: 0;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

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

        .calendar-filter-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .calendar-filter-group {
            border: 1px solid #eef2f7;
            border-radius: 16px;
            background: #f8fafc;
            padding: 1rem;
        }

        .calendar-filter-title {
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.75rem;
        }

        .filter-checkboxes {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .filter-checkbox {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 0.75rem;
            border: 1px solid #dbe2ea;
            border-radius: 999px;
            background: #fff;
            color: #334155;
            font-size: 0.86rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s ease;
            user-select: none;
        }

        .filter-checkbox input {
            display: none;
        }

        .filter-checkbox:hover {
            border-color: #b8c4d6;
            background: #f1f5f9;
        }

        .filter-checkbox.selected {
            background: #111827;
            border-color: #111827;
            color: #fff;
        }

        .calendar-filter-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 0.75rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #eef2f7;
            flex-wrap: wrap;
        }

        .calendar-shell {
            padding: 0.25rem;
        }

        #calendar {
            width: 100%;
        }

        .fc {
            font-family: inherit;
        }

        .fc .fc-toolbar {
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-bottom: 1.25rem !important;
        }

        .fc .fc-toolbar-title {
            font-size: 1.15rem !important;
            font-weight: 800;
            color: #111827;
        }

        .fc .fc-button {
            border-radius: 12px !important;
            border: 1px solid #dbe2ea !important;
            background: #fff !important;
            color: #334155 !important;
            font-weight: 700 !important;
            box-shadow: none !important;
            padding: 0.45rem 0.75rem !important;
        }

        .fc .fc-button:hover,
        .fc .fc-button-active {
            background: #111827 !important;
            border-color: #111827 !important;
            color: #fff !important;
        }

        .fc .fc-daygrid-day-number,
        .fc .fc-col-header-cell-cushion {
            color: #334155;
            text-decoration: none;
            font-weight: 700;
        }

        .fc .fc-daygrid-day-frame {
            min-height: 110px;
        }

        .fc-event {
            border-radius: 10px !important;
            padding: 2px 5px !important;
            border: none !important;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
        }

        .fc-event-status-published {
            background-color: #16a34a !important;
            border-color: #16a34a !important;
            color: white !important;
        }

        .fc-event-status-draft {
            background-color: #f59e0b !important;
            border-color: #f59e0b !important;
            color: #111827 !important;
        }
