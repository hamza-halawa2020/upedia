<?php

namespace Modules\Notifications\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Notifications\Actions\ListUserNotifications;
use Modules\Notifications\Actions\MarkAllNotificationsAsRead;
use Modules\Notifications\Actions\MarkNotificationAsRead;
use Modules\Notifications\Actions\StoreDeviceToken;
use Modules\Notifications\Http\Requests\StoreDeviceTokenRequest;

class NotificationController extends Controller
{
    public function index(ListUserNotifications $listUserNotifications)
    {
        $notifications = $listUserNotifications->handle(Auth::user());

        return view('notifications::index', compact('notifications'));
    }

    public function markAsRead(Request $request, string $id, MarkNotificationAsRead $markNotificationAsRead)
    {
        if ($markNotificationAsRead->handle(Auth::user(), $id)) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Notification not found.'], 404);
    }

    public function markAllAsRead(MarkAllNotificationsAsRead $markAllNotificationsAsRead)
    {
        $markAllNotificationsAsRead->handle(Auth::user());

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'All notifications marked as read.');
    }

    public function storeToken(StoreDeviceTokenRequest $request, StoreDeviceToken $storeDeviceToken)
    {
        $storeDeviceToken->handle(Auth::user(), $request->validated(), $request);

        return response()->json(['success' => true]);
    }
}

