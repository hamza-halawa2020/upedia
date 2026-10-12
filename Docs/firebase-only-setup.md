# Firebase-Only Notifications

Current decision: Firebase is the only realtime notification transport.
Reverb, its browser subscriber and private-channel routes have been removed.
No existing queue jobs, failed jobs or stored notifications were deleted/retried.

## Delivery

- BaseNotification uses the database channel and a shared FirebaseChannel.
- Database serialization no longer makes network requests. Firebase delivery
  delegates to the existing shared FirebaseNotificationService.
- Legacy callers requesting broadcast are mapped to Firebase, not WebSockets.
- Stored records and push payloads share notification_id for frontend deduplication.
- Foreground onMessage updates the shared feed/badge; the service worker handles
  background push. Neither needs Reverb.
- Current delivery is synchronous, matching the prior Firebase behavior. A Queue
  worker is not required for these notifications; unrelated background jobs may
  still require a worker, and IT reminders still require the scheduler.

## Browser Setup

1. Stop the obsolete Reverb process with Ctrl+C.
2. Open https://upedia-all.test and sign in.
3. Refresh after the transport change, then click the notification bell and allow
   browser notifications. Token registration needs a secure context and permission.
4. Confirm token readiness without printing token/key contents:

```powershell
php tests/Integration/NotificationStatus.php admin@example.com
```

5. Send one controlled Firebase test:

```powershell
php artisan notifications:send-test admin@example.com --firebase
```

Without --firebase the command only stores a notification. With --firebase it
requires an active web token. Delivery-request output does not prove browser
receipt; verify the bell updates without refresh and test a background notification.

Server key authentication succeeds, but Web app settings and VAPID must belong
to the same Firebase project. Private service-account contents must never be
copied into frontend configuration, logs, source control or chat.

## Verification

- Current suite: 44 tests, 183 assertions.
- Firebase-only routing, legacy broadcast mapping, shared payload IDs and frontend
  private-credential exclusion have regression tests.
- Actual Firebase receipt still requires a browser token and delivery confirmation.
- Existing imported jobs for missing classes remain separate from this transport
  change; do not retry/delete them blindly.
