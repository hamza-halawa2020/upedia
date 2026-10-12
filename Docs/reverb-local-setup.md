# Local Reverb And Queue Setup

## Current Decision: Firebase Only

Reverb and browser WebSocket subscriptions were removed at the user's request.
Stored notifications remain; new realtime delivery uses the shared FirebaseChannel.
No existing jobs were deleted or retried. Previous Reverb evidence is historical,
not the current architecture. See [Firebase Setup](firebase-only-setup.md).
Current regression suite: 44 tests, 183 assertions. Firebase browser receipt still
needs an active token and a controlled delivery check.

Target: `D:/hamza/upedia-all`. Reverb is installed and registered.
The server binds to localhost only, using port 8080 and HTTP for local testing.
Configure TLS/reverse proxy before HTTPS browser use or production deployment.

## Run Locally

Stop an old unfiltered worker with Ctrl+C first. In separate terminals:

```powershell
php artisan reverb:start
php artisan queue:work --queue=upedia-all-notifications --tries=3
php artisan schedule:work
```

New notification broadcasts explicitly use `upedia-all-notifications`, and the
local database queue default now matches it. No old jobs were deleted/retried.
Long-running workers must be restarted to pick up configuration/code changes.

## Existing Queue Failures

`GenerateScheduleMeetingLinks` and `SendFirebaseNotificationJob` were present in
serialized old queue payloads but their classes do not exist in this project.
They fail as incomplete PHP classes, not because Firebase authentication failed.
Do not create empty compatibility jobs or retry these blindly. Restore their
real implementation with the owning domain or review/archive them explicitly.

An unfiltered `queue:work` previously consumed imported default-queue jobs.
Always name the dedicated queue until the old workload is reviewed.

## Checks

```powershell
php artisan test --filter=BroadcastAuthTest
php tests/Integration/VerifyReverbServer.php
```

The second command requires the Reverb server to be running. It sends a synthetic
signed event to a verification channel, not an actual user notification.
Private notification-channel authorization only permits the matching user ID.

Backend publish acceptance does not establish browser subscription/receipt.
The shared frontend realtime listener and HTTPS/WSS still need verification.
Firebase push is separate: its service account authenticates successfully,
but actual web-token registration and push receipt remain to be tested.

Composer installation added Reverb and its dependencies without updating existing
packages. Composer still reports existing Laravel framework advisories; this
change is not a framework security upgrade.
