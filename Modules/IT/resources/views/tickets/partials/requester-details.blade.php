<dl id="requester-details" class="d-flex gap-4 flex-wrap" hidden
    data-url="{{ route('it.tickets.staffDetails', ['staffId' => '__STAFF__']) }}">
    <div>
        <dt>Department</dt>
        <dd data-field="department_name"></dd>
    </div>
    <div>
        <dt>Manager</dt>
        <dd data-field="manager_name"></dd>
    </div>
    <div>
        <dt>Phone</dt>
        <dd data-field="phone"></dd>
    </div>
</dl>
<p id="requester-details-error" class="text-danger" role="alert" hidden></p>
<script>
    (() => {
        const select = document.getElementById('requester_id');
        const panel = document.getElementById('requester-details');
        const error = document.getElementById('requester-details-error');
        let pending;
        async function refresh() {
            pending?.abort();
            panel.hidden = true;
            error.hidden = true;
            if (!select.value) return;
            pending = new AbortController();
            try {
                const response = await fetch(panel.dataset.url.replace('__STAFF__', encodeURIComponent(select.value)), {
                    headers: { 'Accept': 'application/json' }, signal: pending.signal
                });
                if (!response.ok) throw new Error('Unable to load requester details.');
                const payload = await response.json();
                panel.querySelectorAll('[data-field]').forEach(node => {
                    node.textContent = payload.data[node.dataset.field] ?? '-';
                });
                panel.hidden = false;
            } catch (failure) {
                if (failure.name === 'AbortError') return;
                error.textContent = 'Unable to load requester details.';
                error.hidden = false;
            }
        }
        select.addEventListener('change', refresh);
        refresh();
    })();
</script>