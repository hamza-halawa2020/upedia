@extends('layout.layout')

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-24">
            <div>
                <h6 class="fw-semibold mb-0">Notifications</h6>
            </div>
            <form action="{{ route('notifications.markAllRead') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Mark All as Read</button>
            </form>
        </div>

        <div class="card basic-data-table">
            <div class="card-body p-0">
                @if ($notifications->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table bordered-table mb-0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications as $notification)
                                    @php
                                        $isUnread = $notification->read_at === null;
                                        $actionUrl = $notification->data['action_url'] ?? null;
                                        $message = trim(strip_tags($notification->data['message'] ?? ($notification->data['body'] ?? 'You have a new notification')));
                                    @endphp
                                    <tr class="{{ $isUnread ? 'unread-notification' : '' }}" data-id="{{ $notification->id }}">
                                        <td>{{ $notification->data['title'] ?? 'Notification' }}</td>
                                        <td>{{ $message }}</td>
                                        <td>{{ $notification->created_at->diffForHumans() }}</td>
                                        <td>{{ $isUnread ? 'Unread' : 'Read' }}</td>
                                        <td class="text-center">
                                            @if ($actionUrl)
                                                <a href="{{ $actionUrl }}" class="mark-read-link">Open</a>
                                            @elseif ($isUnread)
                                                <button type="button" class="btn btn-sm btn-primary mark-read-btn">Mark Read</button>
                                            @else
                                                <span>Read</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3">
                        {{ $notifications->links() }}
                    </div>
                @else
                    <div class="p-24 text-center text-secondary-light">No notifications found.</div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $(document).on('click', '.unread-notification .mark-read-link, .unread-notification .mark-read-btn', function(e) {
                    const $btn = $(this);
                    const $item = $btn.closest('[data-id]');
                    const notificationId = $item.data('id');
                    const actionUrl = $btn.attr('href');

                    if (!notificationId) return;

                    e.preventDefault();

                    $.ajax({
                        url: `/notifications/${notificationId}/mark-as-read`,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function() {
                            if (actionUrl && actionUrl !== '#') {
                                window.location.href = actionUrl;
                                return;
                            }

                            $item.removeClass('unread-notification');
                            $item.find('td:eq(3)').text('Read');
                            $btn.closest('td').html('<span>Read</span>');
                        },
                        error: function() {
                            if (actionUrl && actionUrl !== '#') {
                                window.location.href = actionUrl;
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection