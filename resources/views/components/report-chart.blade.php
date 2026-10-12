@props(['chart', 'title', 'id'])
<section class="my-3">
    <h3 class="fs-6">{{ $title }}</h3>
    <div style="height: 260px; width: 100%;"><canvas id="{{ $id }}" aria-label="{{ $title }}" role="img"></canvas></div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof Chart === 'undefined') return;
        const data = @js($chart);
        new Chart(document.getElementById(@js($id)), {
            type: 'bar',
            data: {
                labels: data.labels, datasets: [{
                    label: @js($title), data: data.values,
                    backgroundColor: ['#16856a', '#ca5668', '#478bb0', '#b18b32']
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
    });
</script>