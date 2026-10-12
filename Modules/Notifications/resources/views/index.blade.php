@extends('layout.layout')

@section('content')
    <div class="container-fluid py-4">
        <h1 class="h4 mb-4">Notifications</h1>

        <div class="list-group">
            @forelse ($notifications as $notification)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>{{ data_get($notification->data, 'title', 'Notification') }}</strong>
                            <div class="text-muted small">{{ data_get($notification->data, 'message') }}</div>
                        </div>
                        <span class="text-muted small">{{ $notification->created_at?->diffForHumans() }}</span>
                    </div>
                </div>
            @empty
                <div class="list-group-item text-muted">No notifications found.</div>
            @endforelse
        </div>

        <div class="mt-3">
            {{ $notifications->links() }}
        </div>
    </div>
@endsection

