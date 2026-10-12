@push('scripts')
    <script>
        $(window).on('load', function() {
            $('#loadingSpinner').fadeOut(400);
        });

        let itemToDelete = null;

        function initializeSelect2(scope) {
            $(scope).find('.general-select, .department-select').select2({ allowClear: true, width: '100%' });
        }

        function ensureEmptyState() {
            const hasItems = document.querySelectorAll('#quick-links-container .quick-link-item').length > 0;
            $('#quick-links-empty-state').toggleClass('d-none', hasItems);
        }

        function updateStatusBadge(checkbox) {
            const item = checkbox.closest('.quick-link-item');
            const enabled = checkbox.checked;
            const badge = item.querySelector('.quick-link-item__badge');
            const text = item.querySelector('.quick-link-switch__text');

            badge.classList.toggle('is-active', enabled);
            badge.classList.toggle('is-inactive', !enabled);
            badge.textContent = enabled ? 'Active' : 'Inactive';
            text.textContent = enabled ? 'Enabled' : 'Disabled';
        }

        $(document).ready(function() {
            initializeSelect2(document);
        });

        function addQuickLink() {
            const container = document.getElementById('quick-links-container');
            const template = document.getElementById('quick-link-template');
            const clone = template.content.cloneNode(true);

            container.prepend(clone);
            initializeSelect2(container.querySelector('.quick-link-item[data-id="new"]'));
            ensureEmptyState();
        }

        function quickLinkPayload(item) {
            return {
                _token: "{{ csrf_token() }}",
                name: item.querySelector('[name="name"]').value,
                link: item.querySelector('[name="link"]').value,
                is_active: item.querySelector('[name="is_active"]').checked ? 1 : 0,
                department_ids: $(item).find('[name="department_ids[]"]').val()
            };
        }

        function saveQuickLink(button) {
            const item = button.closest('.quick-link-item');
            const id = item.dataset.id;
            const payload = quickLinkPayload(item);

            if (!payload.name || !payload.link) {
                toastr.error('Name and Link are required');
                return;
            }

            const url = id === 'new'
                ? "{{ route('quick_links.store') }}"
                : "{{ route('quick_links.update', ['quickLink' => '__ID__']) }}".replace('__ID__', id);

            sendQuickLink(button, item, url, id === 'new' ? 'POST' : 'PUT', id === 'new' ? 'Add' : 'Save', payload);
        }

        function sendQuickLink(button, item, url, method, label, payload) {
            button.disabled = true;
            button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

            $.ajax({
                url: url,
                method: method,
                data: payload,
                success: response => afterSave(item, button, response),
                error: xhr => showErrors(xhr, label, button),
                complete: () => button.disabled = false
            });
        }

        function afterSave(item, button, response) {
            toastr.success(response.message);
            item.dataset.id = response.quickLink.id;
            item.querySelector('.quick-link-item__title').textContent = 'Quick Link #' + response.quickLink.id;
            button.innerHTML = 'Save';
            updateStatusBadge(item.querySelector('[name="is_active"]'));
            ensureEmptyState();
        }

        function showErrors(xhr, label, button) {
            const errors = xhr.responseJSON ? xhr.responseJSON.errors : null;

            errors ? Object.values(errors).forEach(error => toastr.error(error[0])) : toastr.error('Something went wrong');
            button.innerHTML = label;
        }

        function removeQuickLink(button) {
            const item = button.closest('.quick-link-item');

            if (item.dataset.id === 'new') {
                item.remove();
                ensureEmptyState();
                return;
            }

            itemToDelete = item.dataset.id;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }

        $('#confirmDeleteBtn').on('click', function() {
            if (!itemToDelete) return;

            const btn = $(this);
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

            $.ajax({
                url: "{{ route('quick_links.destroy', ['quickLink' => '__ID__']) }}".replace('__ID__', itemToDelete),
                method: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: response => removeDeletedItem(response),
                error: () => toastr.error('Failed to delete link'),
                complete: () => btn.prop('disabled', false).text('Delete')
            });
        });

        function removeDeletedItem(response) {
            toastr.success(response.message);
            $(`.quick-link-item[data-id="${itemToDelete}"]`).fadeOut(300, function() {
                $(this).remove();
                ensureEmptyState();
            });
            bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
            itemToDelete = null;
        }
    </script>
@endpush
