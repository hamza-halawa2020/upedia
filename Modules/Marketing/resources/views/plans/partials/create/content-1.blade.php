    @include('components.alert')

    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="space-y-4">

                <x-page-title
                    title="Create Marketing Plan"
                    description="Create a new marketing plan with publish schedule, platform, type, content details, comments, and attachments.">

                    <a href="{{ route('plans.index') }}" class="asset-btn asset-btn--secondary">
                        <iconify-icon icon="ion:arrow-back-outline"></iconify-icon>
                        <span>Back to Plans</span>
                    </a>

                </x-page-title>

                <form action="{{ route('plans.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="ui-card">
                        <div class="form-section">

                            <div class="form-section__head">
                                <h5 class="form-section__title mb-1">Basic Information</h5>
                                <p class="form-section__sub mb-0">
                                    Enter the main plan information, publishing schedule, platform, and content type.
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

                            <div class="asset-form-grid">

                                <div class="asset-col-6">
                                    <label for="name" class="asset-label">
                                        Plan Name <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        class="asset-input @error('name') asset-invalid @enderror"
                                        value="{{ old('name') }}"
                                        placeholder="Enter plan name"
                                        required>

                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="asset-col-6">
                                    <label for="subject" class="asset-label">
                                        Subject <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="subject"
                                        name="subject"
                                        class="asset-input @error('subject') asset-invalid @enderror"
                                        value="{{ old('subject') }}"
                                        placeholder="Enter subject name"
                                        required>

                                    @error('subject')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="asset-col-6 d-none">
                                    <label for="month" class="asset-label">Month</label>

                                    <select
                                        id="month"
                                        name="month"
                                        class="asset-select @error('month') asset-invalid @enderror">

                                        <option value="">Select Month</option>

                                        @foreach ([
                                            'January', 'February', 'March', 'April', 'May', 'June',
                                            'July', 'August', 'September', 'October', 'November', 'December'
                                        ] as $m)
                                            <option value="{{ $m }}" {{ old('month') == $m ? 'selected' : '' }}>
                                                {{ $m }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('month')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="asset-col-6">
                                    <label for="publish_date" class="asset-label">
                                        Publish Date
                                    </label>

                                    <input
                                        type="date"
                                        id="publish_date"
                                        name="publish_date"
                                        class="asset-input @error('publish_date') asset-invalid @enderror"
                                        value="{{ old('publish_date') }}">

                                    @error('publish_date')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="asset-col-6">
                                    <label for="publish_time" class="asset-label">
                                        Publish Time
                                    </label>

                                    <input
                                        type="time"
                                        id="publish_time"
                                        name="publish_time"
                                        class="asset-input @error('publish_time') asset-invalid @enderror"
                                        value="{{ old('publish_time') }}">

                                    @error('publish_time')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="asset-col-6">
                                    <label for="platform" class="asset-label">
                                        Platform <span class="text-danger">*</span>
                                    </label>

                                    <select
                                        id="platform"
                                        name="platform"
                                        class="asset-select @error('platform') asset-invalid @enderror"
                                        required>

                                        <option value="">Select Platform</option>

                                        @foreach (['facebook', 'tiktok', 'youtube', 'X', 'snapchat', 'instagram'] as $platform)
                                            <option value="{{ $platform }}" {{ old('platform') == $platform ? 'selected' : '' }}>
                                                {{ ucfirst($platform) }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('platform')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
