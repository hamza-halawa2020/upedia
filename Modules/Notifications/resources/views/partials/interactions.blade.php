<script>
    const envTest = @json((bool) env('APP_LOCALE_ENV'));

    $(document).ready(function () {

        /*
        |--------------------------------------------------------------------------
        | Logout
        |--------------------------------------------------------------------------
        */
        $(document).on('click', '#logoutBtn', function (e) {
            e.preventDefault();

            const url = envTest ?
                '{{ env('TEST_LOGOUT_URL') }}' :
                '{{ env('LOGOUT_URL') }}';

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                xhrFields: {
                    withCredentials: true
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                success: function (response) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                        return;
                    }

                    if (response.test_url) {
                        window.location.href = response.test_url;
                        return;
                    }

                    window.location.reload();
                },
                error: function () {
                    alert('Logout failed. Please try again.');
                }
            });
        });


        /*
        |--------------------------------------------------------------------------
        | Notification click
        |--------------------------------------------------------------------------
        */
        $(document).on('click', '.notification-link', function (e) {
            const $link = $(this);
            const $item = $link.closest('.notification-item');
            const notificationId = $item.data('id');
            const actionUrl = $link.attr('href') || '#';

            if (!notificationId || !$item.hasClass('unread-notification')) {
                return;
            }

            e.preventDefault();

            $.ajax({
                url: `/notifications/${notificationId}/mark-as-read`,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        $item.removeClass('unread-notification');

                        const $countElem = $('#notification-count');

                        if ($countElem.length) {
                            let count = parseInt($countElem.text(), 10) || 0;
                            count = Math.max(0, count - 1);

                            $countElem.text(count);

                            if (count === 0) {
                                $countElem.hide();
                            }
                        }
                    }

                    if (actionUrl && actionUrl !== '#') {
                        window.location.href = actionUrl;
                    }
                },
                error: function () {
                    // حتى لو حصل error، افتح اللينك عادي
                    if (actionUrl && actionUrl !== '#') {
                        window.location.href = actionUrl;
                    }
                }
            });
        });


        /*
        |--------------------------------------------------------------------------
        | Mark all notifications as read
        |--------------------------------------------------------------------------
        */
        $(document).on('click', '#mark-all-read', function (e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('notifications.markAllRead') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        $('.notification-item').removeClass('unread-notification');
                        $('#notification-count').hide().text('0');
                    }
                }
            });
        });

    });
</script>