<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-head />

    <script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>

   </head>

<body>
    <x-page-loader />

    @if (!Route::is('auth.login'))
        <x-sidebar />
    @endif

    <main class="{{ Route::is('auth.login') ? '' : 'dashboard-main' }}">
        @if (!Route::is('auth.login'))
            <x-navbar />
        @endif

        <div class="{{ Route::is('auth.login') ? '' : 'dashboard-main-body' }}">
            @yield('content')
        </div>

        <x-footer />
    </main>

    <script src="{{ asset('assets/js/lib/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/iconify-icon.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('assets/js/lib/magnifc-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/prism.js') }}"></script>
    <script src="{{ asset('assets/js/lib/file-upload.js') }}"></script>
    <script src="{{ asset('assets/js/lib/audioplayer.js') }}"></script>
    <script src="{{ asset('assets/js/custom-sidebar.js') }}"></script>
    <script src="{{ asset('assets/js/lib/multi-select.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/lib/toaster.js') }}"></script>

    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="{{ asset('assets/js/lib/select2.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css" />

    <script>
        $(document).ready(function() {
            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif

            $('.general-select').select2({
                allowClear: true,
                width: '100%'
            });
        });
    </script>

    @php
        $allowedOrigins = collect([
            config('app.SETTINGS_URL'),
            config('app.ACADEMY_URL'),
            config('app.HR_URL'),
            config('app.FINANCE_URL'),
            config('app.CRM_URL'),
            config('app.Retention_URL'),
            config('app.EXAM_URL'),
            config('app.IT_URL'),
            config('app.MARKETING_URL'),
        ])->filter()->map(fn($url) => rtrim((string) $url, '/'))->values()->all();
    @endphp

    <script>
        (function() {
            var allowedOrigins = @json($allowedOrigins);

            function readTokenFromUrl(urlString) {
                try {
                    var url = new URL(urlString, window.location.origin);
                    return url.searchParams.get('sso_token') || '';
                } catch (e) {
                    return '';
                }
            }

            var ssoToken = readTokenFromUrl(window.location.href);

            if (!ssoToken && document.referrer) {
                ssoToken = readTokenFromUrl(document.referrer);
            }

            if (!ssoToken) {
                return;
            }

            var currentUrl = new URL(window.location.href);
            if (!currentUrl.searchParams.get('sso_token')) {
                currentUrl.searchParams.set('sso_token', ssoToken);
                window.history.replaceState({}, '', currentUrl.toString());
            }

            function decorateAnchor(anchor) {
                var href = anchor.getAttribute('href');
                if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) {
                    return;
                }

                try {
                    var url = new URL(href, window.location.origin);
                    var isSameOrigin = url.origin === window.location.origin;
                    var normalizedOrigin = url.origin.replace(/\/$/, '');
                    var isConfiguredProject = allowedOrigins.includes(normalizedOrigin);

                    if (!isSameOrigin && !isConfiguredProject) {
                        return;
                    }

                    if (!url.searchParams.get('sso_token')) {
                        url.searchParams.set('sso_token', ssoToken);
                        anchor.setAttribute('href', url.toString());
                    }
                } catch (e) {
                    // Ignore malformed links.
                }
            }

            function ensureFormToken(form) {
                var method = (form.getAttribute('method') || 'GET').toUpperCase();
                if (!['GET', 'POST', 'PUT', 'PATCH', 'DELETE'].includes(method)) {
                    return;
                }

                var existing = form.querySelector('input[name="sso_token"]');
                if (existing) {
                    existing.value = ssoToken;
                    return;
                }

                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'sso_token';
                input.value = ssoToken;
                form.appendChild(input);
            }

            document.querySelectorAll('a[href]').forEach(decorateAnchor);
            document.querySelectorAll('form').forEach(ensureFormToken);

            document.addEventListener('click', function(event) {
                var anchor = event.target.closest('a[href]');
                if (anchor) {
                    decorateAnchor(anchor);
                }
            });

            document.addEventListener('submit', function(event) {
                if (event.target instanceof HTMLFormElement) {
                    ensureFormToken(event.target);
                }
            });
        })();
    </script>

    {!! $script ?? '' !!}

    @stack('scripts')
    @yield('scripts')
</body>

</html>
