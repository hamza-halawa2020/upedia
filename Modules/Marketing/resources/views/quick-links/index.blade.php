@extends('layout.layout')

@section('content')
    @include('components.loader')
    @include('components.alert')

    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="space-y-4">
                <x-page-title
                    title="Quick Links Configuration"
                    description="Manage quick links, assign them to departments, and control activation status.">
                    <button type="button" class="asset-btn asset-btn--primary" onclick="addQuickLink()">
                        + Add New Link
                    </button>
                </x-page-title>

                <div class="ui-card">
                    <div class="form-section">
                        <div class="form-section__head">
                            <h5 class="form-section__title mb-1">Manage Links</h5>
                            <p class="form-section__sub mb-0">
                                Add, update, activate, deactivate, or remove department quick links.
                            </p>
                        </div>

                        <div id="quick-links-container" class="quick-links-list">
                            @foreach ($quickLinks as $link)
                                @include('marketing::quick-links.partials.item', ['link' => $link])
                            @endforeach
                        </div>

                        @include('marketing::quick-links.partials.empty-state')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('marketing::quick-links.partials.delete-modal')
    @include('marketing::quick-links.partials.template')
@endsection

@include('marketing::quick-links.partials.styles')
@include('marketing::quick-links.partials.scripts')
