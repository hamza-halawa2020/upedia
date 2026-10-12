    <script>
        $(function () {
            const $visibilitySelect = $('#visibility');
            const $departmentsWrapper = $('#departments-wrapper');
            const $departmentsSelect = $('#department_ids');

            $departmentsSelect.select2({
                width: '100%',
                placeholder: 'Select departments',
                closeOnSelect: false
            });

            function toggleDepartments() {
                const isPublic = $visibilitySelect.val() === 'public';

                $departmentsWrapper.toggleClass('d-none', !isPublic);

                $departmentsSelect.prop({ disabled: !isPublic, required: isPublic }).trigger('change.select2');
            }

            toggleDepartments();
            $visibilitySelect.on('change', toggleDepartments);
        });
    </script>
