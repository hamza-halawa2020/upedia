    <script>
        $(function() {
            let timeout = null;
            const forms = $('form[data-ajax="true"]');
            const $clientNumber = $('#client_number');
            const $clientName = $('#client_name');
            const $department = $('#department');
            const $staff = $('#staff_id');
            const $system = $('[data-field="system"]');
            const $platform = $('[data-field="platform"]');
            const $lookupResults = $('#client_lookup_results');

            function clearAjaxErrors($form) {
                $form.find('[data-field]').removeClass('asset-invalid is-invalid');
                $form.find('[data-error-for]').addClass('d-none').text('');
            }

            function showAjaxErrors($form, errors) {
                Object.entries(errors).forEach(function([field, messages]) {
                    const normalizedField = field.startsWith('attachments.') ? 'attachments' : field;
                    const $input = $form.find(`[data-field="${normalizedField}"]`).first();
                    const $error = $form.find(`[data-error-for="${normalizedField}"]`).first();

                    if ($input.length) {
                        $input.addClass('asset-invalid is-invalid');
                    }

                    if ($error.length) {
                        $error.removeClass('d-none').text(messages[0]);
                    }
                });
            }

            function scrollToFirstError($form) {
                const $firstError = $form.find('[data-error-for]').filter(function() {
                    return !$(this).hasClass('d-none') && $.trim($(this).text()) !== '';
                }).first();

                const $target = $firstError.length
                    ? $firstError
                    : $form.find('.asset-invalid, .is-invalid').first();

                if (!$target.length) {
                    return;
                }

                const targetTop = $target.offset().top - 120;

                $('html, body').stop(true).animate({
                    scrollTop: Math.max(targetTop, 0)
                }, 250);
            }

            forms.on('input change', '[data-field]', function() {
                const $input = $(this);
                const field = $input.data('field');
                const $error = $input.closest('form').find(`[data-error-for="${field}"]`).first();

                $input.removeClass('asset-invalid is-invalid');

                if ($error.length) {
                    $error.addClass('d-none').text('');
                }
            });

            forms.on('submit', function(e) {
                e.preventDefault();

                const $form = $(this);
                const form = this;
                const $submitButton = $form.find('button[type="submit"]').last();
                const submitLabel = $submitButton.data('submit-label') || $.trim($submitButton.text()) || 'Submit';
                $submitButton.data('submit-label', submitLabel);

                function hideGlobalSpinner() {
                    $('#loadingSpinner').stop(true, true).hide();
                }

                function setSubmittingState(submitting) {
                    if (submitting) {
                        $submitButton
                            .prop('disabled', true)
                            .html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>');
                        return;
                    }

                    $submitButton
                        .prop('disabled', false)
                        .html(submitLabel);

                    hideGlobalSpinner();
                }

                clearAjaxErrors($form);
                setSubmittingState(true);

                $.ajax({
                    url: $form.attr('action'),
                    method: $form.attr('method') || 'POST',
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    headers: {
                        Accept: 'application/json'
                    },
                    beforeSend: function() {
                        hideGlobalSpinner();
                    },
                    success: function(response) {
                        setSubmittingState(false);

                        if (response.message) {
                            toastr.success(response.message);
                        }

                        if (response.redirect) {
                            window.location.href = response.redirect;
                        }
                    },
                    error: function(xhr) {
                        setSubmittingState(false);

                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors && Object.keys(xhr.responseJSON.errors).length > 0) {
                            showAjaxErrors($form, xhr.responseJSON.errors && Object.keys(xhr.responseJSON.errors).length > 0);
                            scrollToFirstError($form);
                            return;
                        }

                        const message = xhr.responseJSON && xhr.responseJSON.message
                            ? xhr.responseJSON.message
                            : 'Something went wrong';

                        toastr.error(message);
                    },
                    complete: function() {
                        setSubmittingState(false);
                    }
                });
            });

            function escapeHtml(value) {
                return $('<div>').text(value || '').html();
            }

            function hideLookupResults() {
                $lookupResults.addClass('d-none').empty();
            }

            function setSelectValue($select, value) {
                if (!value || !$select.length) {
                    return;
                }

                if ($select.find('option[value="' + value + '"]').length) {
                    $select.val(value).trigger('change');
                }
            }

            function setInputValue($input, value) {
                if (!value || !$input.length) {
                    return;
                }
