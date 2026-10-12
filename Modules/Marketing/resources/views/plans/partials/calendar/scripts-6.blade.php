    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <script>
        let selectedStatuses = [];
        let selectedPlatforms = [];
        let calendar;

        function updateSelectedCount() {
            const count = selectedStatuses.length + selectedPlatforms.length;
            const selectedCount = document.getElementById('selectedCount');

            if (selectedCount) {
                selectedCount.textContent = `${count} selected`;
            }
        }

        function clearAllFilters() {
            selectedStatuses = [];
            selectedPlatforms = [];

            document.querySelectorAll('.filter-checkbox input[type="checkbox"]').forEach(function(checkbox) {
                checkbox.checked = false;
                checkbox.closest('.filter-checkbox').classList.remove('selected');
            });

            updateSelectedCount();
            updateCalendarEvents();
        }

        function updateCalendarEvents() {
            if (calendar) {
                calendar.refetchEvents();
            }
        }

        function toTitleCase(str) {
            if (!str) {
                return 'N/A';
            }

            return String(str)
                .replace(/_/g, ' ')
                .replace(/-/g, ' ')
                .split(' ')
                .map(function(word) {
                    if (word.length === 0) {
                        return '';
                    }

                    return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
                })
                .join(' ');
        }

        function escapeHtml(value) {
            return String(value || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            if (!calendarEl) {
                return;
            }

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Today',
                    month: 'Month',
                    week: 'Week',
                    day: 'Day',
                },
                eventOrder: 'start,title',

                events: function(fetchInfo, successCallback, failureCallback) {
                    const statuses = selectedStatuses.join(',');
                    const platforms = selectedPlatforms.join(',');

                    $.ajax({
                        url: '/plans/calendar/events',
                        method: 'GET',
                        data: {
                            start: fetchInfo.startStr,
                            end: fetchInfo.endStr,
                            statuses: statuses,
                            platforms: platforms
                        },
                        success: function(data) {
                            if (typeof data === 'string') {
                                try {
                                    data = JSON.parse(data);
                                } catch (e) {
                                    console.error('JSON Parse Error:', e);
                                    failureCallback(e);
                                    return;
                                }
                            }

                            const cleaned = data
                                .filter(function(e) {
                                    return e && typeof e === 'object' && e.title && e.start;
                                })
                                .map(function(e) {
                                    return {
                                        ...e,
                                        extendedProps: (
                                            e.extendedProps &&
                                            typeof e.extendedProps === 'object'
                                        ) ? e.extendedProps : {}
                                    };
                                });

                            successCallback(cleaned);
                        },
                        error: function(error) {
                            console.error('Error fetching calendar events:', error);
                            failureCallback(error);
                        }
                    });
                },

                eventClick: function(info) {
                    const props = info.event.extendedProps || {};

                    document.getElementById('modal-plan-name').textContent =
                        info.event.title ? info.event.title.split(' - ')[0] : 'N/A';

                    document.getElementById('modal-staff').textContent =
                        props.created_by || 'N/A';

                    document.getElementById('modal-platform').textContent =
                        toTitleCase(props.platform);

                    document.getElementById('modal-type').textContent =
                        toTitleCase(props.type);

                    document.getElementById('modal-status').textContent =
                        toTitleCase(props.status);

                    document.getElementById('modal-published').textContent =
                        info.event.start ? info.event.start.toLocaleString() : 'N/A';

                    document.getElementById('modal-subject').textContent =
                        props.subject || 'N/A';

                    document.getElementById('modal-view-link').setAttribute(
                        'href',
                        `/plans/${info.event.id}`
                    );
