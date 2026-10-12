<style>
    /* Navbar */

    .navbar-header {
        padding: 12px 20px;
    }

    .navbar-actions {
        flex-shrink: 0;
    }

    /* avatar */

    .navbar-avatar {
        width: 40px;
        height: 40px;
        object-fit: cover;
    }

    /* icon buttons */

    .navbar-icon-btn {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* responsive */

    @media (max-width:992px) {

        .navbar-actions {
            gap: 10px;
        }

        .navbar-avatar {
            width: 36px;
            height: 36px;
        }

    }

    /* mobile */

    @media (max-width:576px) {

        .back-text {
            display: none;
        }

        .navbar-breadcrumb h1,
        .navbar-breadcrumb h2 {
            font-size: 16px;
        }

    }
</style>


<div class="navbar-header">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

        {{-- Left: Breadcrumb --}}
        <div class="navbar-breadcrumb flex-grow-1">
            <div class="{{ Route::is('auth.login') ? '' : 'dashboard-main-body' }}">
                <x-breadcrumb title="{{ $title ?? '' }}" subTitle="{{ $subTitle ?? '' }}" />
            </div>
        </div>

        {{-- Right: Actions --}}
        <div class="navbar-actions d-flex align-items-center gap-3">

            @if (Auth::user()->hasRole('Super admin'))
                <a href="{{ config('app.general_link') }}"
                    class="asset-btn asset-btn--secondary d-flex align-items-center gap-2 navbar-back-btn">
                    <iconify-icon icon="heroicons:arrow-left"></iconify-icon>
                    <span class="back-text">Back to General</span>
                </a>
            @endif

            @php
                $user = auth()->user();
                $notifications = $user ? $user->notifications()->latest()->take(20)->get() : collect();
                $unreadCount = $user ? $user->unreadNotifications()->count() : 0;
            @endphp

            {{-- Notification dropdown --}}
            <div class="dropdown" id="notificationDropdown">
                <button class="navbar-icon-btn has-indicator" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">

                    <iconify-icon icon="iconoir:bell" class="notification-bell"></iconify-icon>

                    @if (auth()->check())
                        <span id="notification-count" class="notification-count bg-red"
                            style="{{ $unreadCount > 0 ? '' : 'display:none' }}">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </button>

                <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg p-0 navbar-dropdown-menu">

                    {{-- Header --}}
                    <div
                        class="m-16 py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                        <h6 class="text-lg text-primary-light fw-semibold mb-0">Notifications</h6>

                        <button id="mark-all-read"
                            class="text-primary-600 fw-semibold text-sm bg-transparent border-0 p-0">
                            Mark all as read
                        </button>
                    </div>

                    {{-- Notification List --}}
                    <div class="max-h-400-px overflow-y-auto scroll-sm pe-4" id="notification-list">

                        @forelse ($notifications as $notification)
                            <div class="notification-item px-24 py-12 mb-2 {{ $notification->read_at === null ? 'unread-notification' : '' }}"
                                data-id="{{ $notification->id }}">

                                <div class="d-flex align-items-start justify-content-between gap-3">

                                    <a href="{{ $notification->data['action_url'] ?? '#' }}"
                                        class="notification-link text-black hover-bg-transparent hover-text-primary d-flex align-items-start gap-3 text-decoration-none flex-grow-1">

                                        <div>
                                            <h6 class="text-md fw-semibold mb-4">
                                                {{ $notification->data['title'] ?? 'Notification' }}
                                            </h6>

                                            <p class="mb-0 text-sm text-secondary-light">
                                                {{ $notification->data['message'] ?? 'You have a new notification' }}
                                            </p>
                                        </div>

                                    </a>

                                    <span class="text-sm text-secondary-light flex-shrink-0">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>

                                </div>

                            </div>

                        @empty

                            <div class="px-24 py-16 text-center text-secondary-light">
                                No notifications yet
                            </div>
                        @endforelse

                    </div>

                    {{-- Footer --}}
                    <div class="text-center py-12 px-16">
                        <a href="{{ route('notifications.index') }}" class="text-primary-600 fw-semibold text-md">
                            See All Notification
                        </a>
                    </div>

                </div>
            </div>

            {{-- Profile dropdown --}}


            <div class="dropdown">

                <button class="navbar-profile-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">

                    @php
                        $user = Auth::user();
                        $profileImage = $user->staff->staff_photo ?? asset('assets/images/logo-icon.png');
                    @endphp

                    <img src="{{ $profileImage }}" class="rounded-circle navbar-avatar" alt="profile">

                </button>

                <div class="dropdown-menu to-top dropdown-menu-sm navbar-dropdown-menu">
                    <div class="py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">

                        <div>
                            <h6 class="text-lg text-primary-light fw-semibold mb-2">
                                <a href="{{ config('app.HR_URL') }}profile">
                                    {{ Auth::user()?->full_name ?? (Auth::user()?->first_name ?? 'Guest') }}
                                </a>
                            </h6>
                        </div>

                        <ul class="to-top-list">

                            <li>
                                <button type="button" id="logoutBtn"
                                    class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-danger d-flex align-items-center gap-3 bg-transparent border-0">

                                    <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon>

                                    Log Out

                                </button>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>

@push('scripts')
    <script>
        const envTest = @json((bool) env('APP_LOCALE_ENV'));

        $(document).ready(function() {

            /*
            |--------------------------------------------------------------------------
            | Logout
            |--------------------------------------------------------------------------
            */
            $(document).on('click', '#logoutBtn', function(e) {
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
                    success: function(response) {
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
                    error: function() {
                        alert('Logout failed. Please try again.');
                    }
                });
            });


            /*
            |--------------------------------------------------------------------------
            | Notification click
            |--------------------------------------------------------------------------
            */
            $(document).on('click', '.notification-link', function(e) {
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
                    success: function(response) {
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
                    error: function() {
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
            $(document).on('click', '#mark-all-read', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('notifications.markAllRead') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.notification-item').removeClass('unread-notification');
                            $('#notification-count').hide().text('0');
                        }
                    }
                });
            });

        });
    </script>

    <script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js"></script>
    <script>
        const settingFirebaseConfig = {
            apiKey: "{{ config('services.firebase.api_key') }}",
            authDomain: "{{ config('services.firebase.auth_domain') }}",
            projectId: "{{ config('services.firebase.project_id') }}",
            messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
            appId: "{{ config('services.firebase.app_id') }}"
        };

        const hasFirebaseValue = (value) => {
            const normalized = String(value ?? '').trim();
            return normalized !== '' && !normalized.includes(String.fromCharCode(123, 123));
        };
        const firebaseEnabled = ['apiKey', 'projectId', 'messagingSenderId', 'appId'].every((key) =>
            hasFirebaseValue(settingFirebaseConfig[key])
        );

        if (firebaseEnabled && 'serviceWorker' in navigator && 'Notification' in window) {
            const workerParams = new URLSearchParams(settingFirebaseConfig).toString();

            navigator.serviceWorker.register(`/firebase-messaging-sw.js?${workerParams}`)
                .then(function(registration) {
                    if (!firebase.apps.length) {
                        firebase.initializeApp(settingFirebaseConfig);
                    }

                    const messaging = firebase.messaging();

                    if (messaging.useServiceWorker) {
                        messaging.useServiceWorker(registration);
                    }

                    Notification.requestPermission().then(function(permission) {
                        if (permission === 'granted') {
                            messaging.getToken({
                                    vapidKey: "{{ config('services.firebase.vapid_key') }}",
                                    serviceWorkerRegistration: registration
                                })
                                .then(function(token) {
                                    if (!token) return;

                                    fetch("{{ route('notifications.storeToken') }}", {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({
                                            device_token: token,
                                            device_type: 'web',
                                            device_name: navigator.userAgent
                                        })
                                    }).catch(function() {});
                                })
                                .catch(function() {});
                        }
                    });

                    messaging.onMessage(function(payload) {
                        console.log('[Setting Firebase] foreground payload received', payload);
                        const title =
                            payload.notification?.title ||
                            payload.data?.title ||
                            payload.data?.notification_title ||
                            'New Notification';

                        const body =
                            payload.notification?.body ||
                            payload.data?.body ||
                            payload.data?.message ||
                            payload.data?.notification_body ||
                            '';

                        const actionUrl = payload.data?.action_url || '#';
                        const escapeHtml = (value) => String(value ?? '').replace(/[&<>"']/g, (char) => ({
                            '&': '&amp;',
                            '<': '&lt;',
                            '>': '&gt;',
                            '"': '&quot;',
                            "'": '&#039;'
                        }[char]));

                        const notificationTag = window.location.origin + '-' + (payload.data?.notification_id || Date.now());

                        const countElem = document.getElementById('notification-count');
                        if (countElem) {
                            let count = parseInt((countElem.innerText || '0').trim(), 10) || 0;
                            count++;
                            countElem.innerText = String(count);
                            countElem.style.display = '';
                        }

                        const list = document.getElementById('notification-list');
                        if (list) {
                            const newItem = `
                            <div class="notification-item px-24 py-12 mb-2 unread-notification" data-id="">
                                <div class="d-flex align-items-start justify-content-between gap-3">
                                    <a href="${escapeHtml(actionUrl)}"
                                       class="notification-link text-black hover-bg-transparent hover-text-primary d-flex align-items-start gap-3 text-decoration-none flex-grow-1">
                                        <div>
                                            <h6 class="text-md fw-semibold mb-4">${escapeHtml(title)}</h6>
                                            <p class="mb-0 text-sm text-secondary-light">${escapeHtml(body)}</p>
                                        </div>
                                    </a>
                                    <span class="text-sm text-secondary-light flex-shrink-0">Just now</span>
                                </div>
                            </div>
                        `;

                            list.insertAdjacentHTML('afterbegin', newItem);
                        }
                        if (Notification.permission === 'granted') {
                            registration.showNotification(title, {
                                body: body,
                                icon: '/assets/images/logo-icon.png',
                                tag: notificationTag,
                                renotify: true,
                                data: {
                                    ...(payload.data || {}),
                                    action_url: actionUrl
                                }
                            });
                        }
                    });

                })
                .catch(function(error) {
                    console.error('Firebase service worker registration failed:', error);
                });
        }
    </script>@endpush
