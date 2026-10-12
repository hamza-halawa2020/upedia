
                    const myModal = new bootstrap.Modal(document.getElementById('eventModal'));
                    myModal.show();
                },

                eventDidMount: function(info) {
                    const status = info.event.extendedProps.status;

                    if (status) {
                        info.el.classList.add(`fc-event-status-${status}`);
                    }
                },

                eventContent: function(arg) {
                    const formattedStart = arg.event.start
                        ? arg.event.start.toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        })
                        : '';

                    const eventTitle = arg.event.title
                        ? arg.event.title.split(' - ')[0]
                        : '';

                    return {
                        html: `
                            <div class="calendar-event-content">
                                <span class="calendar-event-time">${escapeHtml(formattedStart)}</span>
                                <span class="calendar-event-title">${escapeHtml(eventTitle)}</span>
                            </div>
                        `
                    };
                }
            });

            document.querySelectorAll('.filter-checkbox input[type="checkbox"]').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const value = this.value;
                    const filterType = this.getAttribute('data-filter-type');
                    const label = this.closest('.filter-checkbox');

                    let selectedArray = filterType === 'status'
                        ? selectedStatuses
                        : selectedPlatforms;

                    if (this.checked) {
                        if (!selectedArray.includes(value)) {
                            selectedArray.push(value);
                        }

                        label.classList.add('selected');
                    } else {
                        selectedArray = selectedArray.filter(function(item) {
                            return item !== value;
                        });

                        label.classList.remove('selected');
                    }

                    if (filterType === 'status') {
                        selectedStatuses = selectedArray;
                    } else {
                        selectedPlatforms = selectedArray;
                    }

                    updateSelectedCount();
                    updateCalendarEvents();
                });
            });

            updateSelectedCount();
            calendar.render();
        });
    </script>
