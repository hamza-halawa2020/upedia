@extends('layout.layout')

@php
    $title = 'Dashboard';
    $subTitle = 'Overview';
@endphp

@section('content')
    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="d-flex flex-column gap-4">
                <x-page-title
                    title="Dashboard"
                    description="Use the shared settings shell to move between systems and manage the core configuration pages."
                >
                        <a href="{{ route('settings') }}" class="asset-btn asset-btn--primary">
                            Open Systems
                        </a>
                        <a href="{{ route('tabs.index') }}" class="asset-btn asset-btn--secondary">
                            Manage Tabs
                        </a>
                </x-page-title>

                <div class="ui-card border-0 shadow-sm bg-white">
                    <div class="card-body p-3 p-sm-5 text-center">
                        @if (config('app.client_name') == 'Alkarim')
                            <img src="{{ asset('assets/images/alkarim-dark.png') }}" alt="Alkarim" class="mb-3"
                                style="max-width: 220px;">
                        @elseif(config('app.client_name') == 'Upedia')
                            <img src="{{ asset('assets/images/logo.png') }}" alt="Upedia" class="mb-3"
                                style="max-width: 220px;">
                        @else
                            <img src="{{ asset('assets/images/tailors.png') }}" alt="Tailors" class="mb-3"
                                style="max-width: 220px;">
                        @endif

                        <h3 class="mb-2">Settings Workspace</h3>
                        <p class="text-secondary-light mb-0 mx-auto" style="max-width: 760px;">
                            The project now follows the same page shell and component structure as the reference
                            project, so every management screen can reuse the same layout, navbar, sidebar, and shared
                            table components.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
