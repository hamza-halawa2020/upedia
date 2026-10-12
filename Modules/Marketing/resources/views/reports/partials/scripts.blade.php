    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (() => {
            const sections = @json($sections);
            const chartInstances = {};
            const chartColors = ['#111827', '#334155', '#475569', '#64748b', '#94a3b8', '#cbd5e1'];

            const buildChartConfig = (chart) => {
                const labels = chart.labels && chart.labels.length ? chart.labels : ['No Data'];
                const values = chart.series && chart.series.length ? chart.series : [0];
                const isLine = chart.type === 'line';

                return {
                    type: isLine ? 'line' : 'bar',
                    data: {
                        labels,
                        datasets: [{
                            data: values,
                            borderColor: isLine ? '#111827' : chartColors,
                            backgroundColor: isLine ? 'rgba(17, 24, 39, 0.08)' : chartColors,
                            fill: isLine,
                            tension: 0.32,
                            borderWidth: isLine ? 2 : 0,
                            pointRadius: isLine ? 3 : 0,
                            pointHoverRadius: isLine ? 4 : 0,
                            borderRadius: isLine ? 0 : 8,
                            maxBarThickness: 38
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: false,
                        onClick(event, elements) {
                            if (!elements.length) {
                                return;
                            }

                            const index = elements[0].index;
                            const targetUrl = (chart.urls || [])[index];

                            if (targetUrl) {
                                window.location.href = targetUrl;
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label(context) {
                                        const suffix = chart.suffix || '';
                                        const value = context.parsed.y ?? context.parsed ?? 0;
                                        return `${value}${suffix}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#64748b',
                                    maxRotation: 0,
                                    autoSkip: true
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#eef2f7'
                                },
                                ticks: {
                                    precision: 0,
                                    color: '#64748b',
                                    callback(value) {
                                        return `${value}${chart.suffix || ''}`;
                                    }
                                }
                            }
                        }
                    }
                };
            };

            const ensureChartsForTab = (tabName) => {
                const section = sections[tabName];

                if (!section) {
                    return;
                }

                ['left', 'right'].forEach((side) => {
                    const instanceKey = `${tabName}:${side}`;

                    if (chartInstances[instanceKey]) {
                        return;
                    }

                    const canvas = document.getElementById(`chart-${tabName}-${side}`);
                    const chart = section[side] && section[side].chart;

                    if (!canvas || !chart) {
                        return;
                    }

                    chartInstances[instanceKey] = new Chart(canvas, buildChartConfig(chart));
                });
            };

            const activateTab = (tabName) => {
                const availableTabs = Object.keys(sections);
                const fallbackTab = availableTabs[0] || 'overview';
                const targetTab = availableTabs.includes(tabName) ? tabName : fallbackTab;
                const targetButton =
                    document.querySelector(`.tab-link[data-tab="${targetTab}"]`) ||
                    document.querySelector(`.tab-link[data-tab="${fallbackTab}"]`);

                document.querySelectorAll('.tab-link').forEach((button) => button.classList.remove('active'));
                document.querySelectorAll('.tab-pane-panel').forEach((panel) => panel.classList.remove('active'));

                if (!targetButton) {
                    return;
                }

                targetButton.classList.add('active');

                const targetPanel = document.getElementById(`tab-${targetButton.dataset.tab}`);

                if (targetPanel) {
                    targetPanel.classList.add('active');
                }

                ensureChartsForTab(targetButton.dataset.tab);

                if (window.location.hash !== `#${targetButton.dataset.tab}`) {
                    history.replaceState(null, '', `#${targetButton.dataset.tab}`);
                }

                localStorage.setItem('marketing_report_active_tab', targetButton.dataset.tab);

                setTimeout(() => {
                    Object.entries(chartInstances).forEach(([instanceKey, chart]) => {
                        if (!instanceKey.startsWith(`${targetButton.dataset.tab}:`)) {
                            return;
                        }

                        chart.resize();
                        chart.update('none');
                    });
                }, 60);
            };

            document.querySelectorAll('.tab-link').forEach((button) => {
                button.addEventListener('click', (event) => {
                    event.preventDefault();
                    activateTab(button.dataset.tab);
                });
            });

            window.addEventListener('hashchange', () => {
                const hashTab = window.location.hash.replace('#', '');
                if (hashTab) {
                    activateTab(hashTab);
                }
            });

            const hashTab = window.location.hash.replace('#', '');
            const savedTab = localStorage.getItem('marketing_report_active_tab');
            activateTab(hashTab || savedTab || Object.keys(sections)[0] || 'overview');
        })();
    </script>
