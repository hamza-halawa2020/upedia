# Marketing And IT Final Acceptance

## Current Decision: Firebase Only

Reverb and browser WebSocket subscriptions were removed at the user's request.
Stored notifications remain; new realtime delivery uses the shared FirebaseChannel.
No existing jobs were deleted or retried. Previous Reverb evidence is historical,
not the current architecture. See [Firebase Setup](firebase-only-setup.md).
Current regression suite: 44 tests, 183 assertions. Firebase browser receipt still
needs an active token and a controlled delivery check.

## Reverb Configuration Update

- Reverb is installed, registered and tested on localhost:8080. A signed synthetic
  broadcast was accepted; private user-channel authorization tests pass.
- New notification broadcasts and local workers use upedia-all-notifications.
  Imported default-queue jobs were not deleted or retried. Missing legacy job
  classes remain the responsibility of their original domains.
- Firebase service-account OAuth succeeds. Browser receipt, HTTPS/WSS and actual
  user push delivery are still unverified. Server configuration is not final sign-off.
- See [Local Reverb Setup](reverb-local-setup.md) for commands and limitations.

Date: 2026-10-12. Target: `D:/hamza/upedia-all`.
Local test URL: `http://upedia-all.test`.

## Decision

**Not signed off for final migration or production deployment.** The checks below
pass, but they do not establish complete CRUD/interaction parity, external
notification delivery or migration of original data and files.

The user confirmed the local project has an independent test database and
approved assigning the three new permissions to Super admin only.
No login password is stored in the verification scripts or documentation.

## Evidence

| Check | Result | Scope |
| --- | --- | --- |
| Current PHPUnit suite | PASS: 43 tests, 178 assertions | Isolated SQLite; includes permission seeder idempotency |
| Selected MySQL assertions | PASS: 11 | Deadline schema/rollback, SLA hours, selected report SQL |
| Fresh MySQL installation | PASS: all 681 migrations | Disposable Docker schema, not the shared database |
| DatabaseSeeder | PASS | Disposable Docker schema; external delivery faked |
| Authenticated HTTP smoke | PASS: 33 routes returned 200 | Local admin; list/create forms, reports, calendar and dashboards |
| Local permission audit | PASS: zero missing/unassigned | Three new permissions granted only to Super admin |
| Legacy attachment preview | PASS: zero candidates/errors | Current local test DB only; no production file transfer |
| Scoped 200-line check | PASS | Both domain modules, shared attachment actions and readiness queries |
| Browser interaction/screenshots | NOT VERIFIED | Browser connector unavailable; HTTP checks are not visual checks |
| Complete CRUD and source parity | NOT VERIFIED | HTTP smoke checks do not create/update/delete business records |
| Firebase/broadcast/queue delivery | NOT CONFIGURED | User confirmed these services are not ready |
| Original data/file migration | NOT VERIFIED | Empty test attachment preview is not production evidence |

## Changes Made During Acceptance

- Added `ModulePermissionDefinitionsSeeder` so a fresh installation defines
  route-required module permissions before the existing Super admin role setup.
- Added `ModuleReadinessPermissionSeeder` for expense/purchase status changes and
  notification configuration. On the local test DB only those three grants were
  added to Super admin, as explicitly approved; other role grants were unchanged.
- Added repeatable isolated full-install verification and authenticated HTTP
  smoke checks. Smoke credentials come from process environment, never source code.

## Repeat Verification

```powershell
php artisan test
php artisan migration:audit-permissions
docker start upedia-verification-20261012
php tests/Integration/VerifyFreshMysql.php --reset --seed
docker stop upedia-verification-20261012
```

Fresh verification is hardwired to a separate, marked disposable schema. It
disables external notifications/mail/HTTP and does not load production into it.
It is not an approval to run reset commands on the local application database.

`tests/Integration/HttpSmoke.php` requires `UPEDIA_SMOKE_EMAIL` and
`UPEDIA_SMOKE_PASSWORD` in the process environment. It checks server responses,
not browser rendering, and only makes login/logout writes.

## Required To Close Acceptance

1. Exercise create/edit/delete, attachment lifecycle, exports, filters and calendar
   interactions in a real browser with admin and representative restricted roles.
2. Configure staging Firebase, broadcasting, queue and scheduler, then verify one
   controlled notification's actual delivery and reminder repeat-run behavior.
3. Validate representative original records and migrate/retire old public file
   URLs after reviewing dependent applications and backups.
4. Resolve or explicitly accept remaining source layout/PDF differences and
   upload reconciliation behavior after outer rollback/process failure.

Only update this decision after recording evidence for the missing checks.
