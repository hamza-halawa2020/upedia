@extends('layout.layout')

@section('content')
    @include('components.alert')

    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="space-y-4">

                <x-page-title
                    title="Edit Complain"
                    description="Update complaint details, client information, sales member, priority, status, notes, and attachments.">

                    <a href="{{ route('complains.index') }}" class="asset-btn asset-btn--secondary">
                        <iconify-icon icon="ion:arrow-back-outline"></iconify-icon>
                        <span>Back to Complains</span>
                    </a>

                </x-page-title>

                <form action="{{ route('complains.update', $complain->id) }}" method="POST" enctype="multipart/form-data" data-ajax="true" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="ui-card">
                        <div class="form-section">

                            <div class="form-section__head">
                                <h5 class="form-section__title mb-1">Complain Details</h5>
                                <p class="form-section__sub mb-0">
                                    Review and update the complaint source, client information, responsible sales member, and resolution details.
                                </p>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @include('marketing::complaints.form', ['complain' => $complain])

                            <div class="asset-actions">
                                <a href="{{ route('complains.index') }}" class="asset-btn asset-btn--secondary">
                                    Cancel
                                </a>

                                <button type="submit" class="asset-btn asset-btn--primary">
                                    Update Complain
                                </button>
                            </div>

                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .select2-container {
            display: block !important;
            width: 100% !important;
        }

        .select2-selection--single,
        .select2-selection--multiple {
            min-height: 44px !important;
            border: 1px solid #dbe2ea !important;
            border-radius: 12px !important;
            width: 100% !important;
            display: flex !important;
            align-items: center !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 42px !important;
            padding-left: 0.9rem !important;
            color: #111827 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 42px !important;
        }
    </style>
@endpush
