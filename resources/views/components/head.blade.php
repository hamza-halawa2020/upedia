<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

@auth
    <meta name="user-id" content="{{ auth()->id() }}">
@endauth

<title>
    @if (config('app.client_name') == 'Alkarim')
        Alkarim
    @elseif(config('app.client_name') == 'Upedia')
        Upedia
    @else
        Tailors
    @endif
</title>

<link rel="icon" type="image/png" href="{{ asset('assets/images/logo-icon.png') }}" sizes="16x16">
<link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/lib/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/lib/apexcharts.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/lib/dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/lib/editor-katex.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/lib/editor.atom-one-dark.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/lib/editor.quill.snow.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/lib/flatpickr.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/lib/full-calendar.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/lib/jquery-jvectormap-2.0.5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/lib/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/lib/slick.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/lib/prism.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/lib/file-upload.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/lib/audioplayer.css') }}">

@if (config('app.client_name') == 'Alkarim')
    <link rel="stylesheet" href="{{ asset('assets/css/alkarim-style.css') }}">
@elseif(config('app.client_name') == 'Upedia')
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@else
    <link rel="stylesheet" href="{{ asset('assets/css/tailors-style.css') }}">
@endif

<link rel="stylesheet" href="{{ asset('assets/css/lib/multi-select.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<link href="{{ asset('assets/css/lib/toaster.css') }}" rel="stylesheet" />

<style>
    html,
    body {
        overflow-x: hidden;
        width: 100%;
    }

    body {
        font-family: 'Inter', sans-serif;
    }

    img,
    svg,
    video,
    canvas,
    iframe {
        max-width: 100%;
        height: auto;
    }

    .notification-bell {
        position: relative;
        cursor: pointer;
        font-size: 20px;
        color: var(--light-text);
    }

    .notification-count {
        position: absolute;
        top: -8px;
        right: -8px;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }

    .unread-notification {
        background-color: #f0f9ff;
        border-left: 3px solid #3b82f6;
    }

    .notification-item {
        transition: background-color 0.2s ease;
    }

    .notification-item:hover {
        background-color: #f9fafb;
    }

    .select2-container {
        width: 100% !important;
        max-width: 100%;
    }

    .select2-selection--single,
    .select2-selection--multiple {
        width: 100% !important;
        min-height: 44px;
    }

    .select2-container--default .select2-selection--single {
        height: 44px !important;
    }
</style>

 <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-sidebar.css') }}">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html,
        body {
            overflow-x: hidden;
            width: 100%;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        img,
        svg,
        video,
        canvas,
        iframe {
            max-width: 100%;
            height: auto;
        }

        .app-bg {
            min-height: 100vh;
            width: 100%;
        }

        .page-shell {
            width: 100%;
            max-width: 1600px;
            margin-inline: auto;
            padding-inline: 1rem;
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        @media (min-width: 640px) {
            .page-shell {
                padding-inline: 1.5rem;
            }
        }

        @media (max-width: 1020px) {
            .page-title {
                margin-top: 25px;
            }
        }

        @media (min-width: 1024px) {
            .page-shell {
                padding-inline: .5rem;
            }
        }

        .page-title {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            justify-content: space-between;
            gap: 0.75rem;
        }

        .page-title>div {
            flex: 1 1;
            min-width: 0;
        }

        .dashTitle {
            font-size: 1.25rem;
            line-height: 1.2;
            font-weight: 700;
            margin: 0;
            word-break: break-word;
        }

        .dashText {
            margin-top: 0.35rem;
            font-size: 0.875rem;
            line-height: 1.5;
            color: #64748b;
            word-break: break-word;
        }

        @media (min-width: 640px) {
            .dashTitle {
                font-size: 1.5rem;
            }

            .dashText {
                font-size: 0.95rem;
            }
        }

        .asset-btn,
        .asset-btn--primary,
        .asset-btn--secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            min-height: 42px;
            padding: 0.7rem 1rem;
            border-radius: 0.9rem;
            text-align: center;
            white-space: nowrap;
            text-decoration: none;
        }

        @media (max-width: 639px) {

            .page-title .asset-btn,
            .page-title .asset-btn--primary,
            .page-title .asset-btn--secondary {
                width: 100%;
            }
        }

        .ui-card {
            width: 100%;
            border-radius: 1.25rem;
            overflow: hidden;
        }

        .ui-card__header {
            padding: 1rem 1rem 0.85rem;
        }

        @media (min-width: 640px) {
            .ui-card__header {
                padding: 1.25rem 1.25rem 1rem;
            }
        }

        .ui-field-box {
            padding: 1rem;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            min-width: 0;
        }

        @media (min-width: 640px) {
            .ui-field-box {
                border-radius: 1.25rem;
            }
        }

        .form-control,
        .form-select,
        .general-select {
            width: 100%;
            min-width: 0;
        }

        .ui-table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .ui-table {
            width: 100%;
            min-width: 760px;
            border-collapse: separate;
            border-spacing: 0;
        }

        @media (max-width: 767px) {
            .ui-table {
                min-width: 680px;
            }
        }

        .ui-table th,
        .ui-table td {
            vertical-align: middle;
            white-space: nowrap;
        }

        .ui-table td .ui-title,
        .ui-table td .ui-muted {
            white-space: normal;
        }

        .ui-actions {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .select2-container {
            width: 100% !important;
            max-width: 100%;
        }

        .select2-selection--single,
        .select2-selection--multiple {
            width: 100% !important;
            min-height: 44px;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        .select2-container--default .select2-selection--single {
            height: 44px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #000 !important;
        }

        .select2-selection__clear {
            display: none !important;
        }

        @media (max-width: 767px) {

            .dashboard-main,
            .dashboard-main-body {
                min-width: 0 !important;
                width: 100% !important;
            }

            .navbar-actions {
                gap: 0.75rem !important;
            }

            .navbar-dropdown-menu {
                width: min(92vw, 360px) !important;
                max-width: 92vw !important;
            }
        }
    </style>

@stack('styles')
