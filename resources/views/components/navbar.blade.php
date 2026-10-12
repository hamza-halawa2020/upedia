@include('components.navbar.styles')
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
    <script src="{{ asset('assets/js/notification-feed.js') }}"></script>
    @include('notifications::partials.interactions')
    @include('notifications::partials.firebase-client')
@endpush
