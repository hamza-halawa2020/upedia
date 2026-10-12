@extends('layout.layout')

@php
    $title = 'Systems';
    $subTitle = 'Project Access';
@endphp

@section('content')
    <div id="systems-loader" class="systems-loader">
        <div class="systems-loader__spinner"></div>
    </div>

    <div id="systems-content" class="container-fluid app-bg invisible">
        <div class="page-shell">
            <div class="d-flex flex-column gap-4">
                <x-page-title
                    title="Choose Your Service"
                    description="Click a service below to get started."
                />

                <div class="systems-grid">
                    @foreach ($projects as $project)
                        <a href="{{ config('app.' . $project['url']) }}" class="system-card">
                            @if (config('app.client_name') == 'Alkarim')
                                <div class="system-card__logo system-card__logo--alkarim">
                                    <img src="{{ asset('assets/images/alkarim-dark.png') }}" alt="{{ $project['name'] }} Icon">
                                </div>
                            @elseif(config('app.client_name') == 'Upedia')
                                <div class="system-card__logo">
                                    <img src="{{ asset('assets/images/logo.png') }}" alt="{{ $project['name'] }} Icon">
                                </div>
                            @else
                                <div class="system-card__logo">
                                    <img src="{{ asset('assets/images/tailors.png') }}" alt="{{ $project['name'] }} Icon">
                                </div>
                            @endif

                            <h5 class="system-card__title">{{ $project['name'] }}</h5>
                            <p class="system-card__description">{{ $project['description'] }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        #app-sidebar,
        .sidebar-open-btn,
        .navbar-back-btn {
            display: none !important;
        }

        .dashboard-main,
        .dashboard-main-body {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
        }

        /* .dashboard-main-body {
            min-height: calc(100vh - 72px);
        } */

        .systems-loader {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.96);
            transition: opacity .45s ease, visibility .45s ease;
        }

        .systems-loader.is-hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .systems-loader__spinner {
            width: 72px;
            height: 72px;
            border: 5px solid #dbeafe;
            border-top-color: #2563eb;
            border-radius: 50%;
            animation: systems-spin 1s linear infinite;
        }

        @keyframes systems-spin {
            to {
                transform: rotate(360deg);
            }
        }

        #systems-content.invisible {
            visibility: hidden;
        }

        .systems-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .system-card {
            min-height: 100%;
            padding: 2rem;
            border-radius: 1.5rem;
            border: 1px solid #e5e7eb;
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
            text-decoration: none;
            text-align: center;
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .system-card:hover {
            transform: translateY(-6px) scale(1.01);
            box-shadow: 0 24px 45px rgba(15, 23, 42, 0.10);
            border-color: #bfdbfe;
        }

        .system-card__logo {
            width: 100px;
            height: 100px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            padding: 1rem;
            background: #eff6ff;
            transition: background-color .25s ease;
        }

        .system-card__logo--alkarim {
            background: #fff0b9;
        }

        .system-card:hover .system-card__logo {
            background: #dbeafe;
        }

        .system-card:hover .system-card__logo--alkarim {
            background: #f4d03f;
        }

        .system-card__logo img {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        .system-card__title {
            margin: .5rem 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
        }

        .system-card__description {
            margin: 0;
            font-size: 0.95rem;
            line-height: 1.75;
            color: #6b7280;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            min-height: 3.2rem;
        }

        @media (max-width: 768px) {
            .systems-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        window.addEventListener('load', () => {
            const loader = document.getElementById('systems-loader');
            const content = document.getElementById('systems-content');

            if (loader) {
                loader.classList.add('is-hidden');
            }

            if (content) {
                content.classList.remove('invisible');
            }
        });
    </script>
@endpush
