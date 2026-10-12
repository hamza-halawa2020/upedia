
                $input.val(value).trigger('change');
            }

            function applyClientMatch(match) {
                setInputValue($clientNumber, match.phone || '');
                setInputValue($clientName, match.client_name || '');
                setInputValue($system, match.system || '');
                $clientName.addClass('is-valid');

                setSelectValue($department, match.department);
                setSelectValue($platform, match.platform);
                setSelectValue($staff, match.staff_id);

                setTimeout(function() {
                    $clientName.removeClass('is-valid');
                }, 2000);

                hideLookupResults();
            }

            function renderLookupResults(matches) {
                if (!matches.length) {
                    $lookupResults
                        .data('matches', [])
                        .html('<div class="phone-lookup-empty">No matching client numbers found.</div>')
                        .removeClass('d-none');
                    return;
                }

                const html = matches.map(function(match, index) {
                    const meta = [
                        match.phone,
                        match.system,
                        match.staff_name ? 'Agent: ' + match.staff_name : null
                    ].filter(Boolean).join(' | ');

                    return '<button type="button" class="phone-lookup-option" data-index="' + index + '">' +
                        '<span>' +
                            '<span class="phone-lookup-name">' + escapeHtml(match.client_name || 'Unknown customer') + '</span>' +
                            '<span class="phone-lookup-meta">' + escapeHtml(meta) + '</span>' +
                        '</span>' +
                        '<span class="phone-lookup-source">' + escapeHtml(match.source_label || '') + '</span>' +
                    '</button>';
                }).join('');

                $lookupResults
                    .data('matches', matches)
                    .html(html)
                    .removeClass('d-none');
            }

            $lookupResults.on('mousedown', '.phone-lookup-option', function(e) {
                e.preventDefault();
                const matches = $lookupResults.data('matches') || [];
                const match = matches[$(this).data('index')];

                if (match) {
                    applyClientMatch(match);
                }
            });

            $(document).on('mousedown', function(e) {
                if (!$(e.target).closest('.phone-lookup-wrap').length) {
                    hideLookupResults();
                }
            });

            $clientNumber.on('input focus', function() {
                const clientNumber = $(this).val();

                clearTimeout(timeout);

                if (clientNumber.length < 3) {
                    hideLookupResults();
                    return;
                }

                timeout = setTimeout(function() {
                    $.ajax({
                        url: "{{ route('leads.check') }}",
                        method: "GET",
                        data: {
                            client_number: clientNumber
                        },
                        beforeSend: function() {
                            $lookupResults
                                .data('matches', [])
                                .html('<div class="phone-lookup-empty">Searching...</div>')
                                .removeClass('d-none');
                        },
                        success: function(res) {
                            renderLookupResults(res.matches || []);
                        },
                        error: function() {
                            hideLookupResults();
                        }
                    });
                }, 300);
            });
        });
    </script>
