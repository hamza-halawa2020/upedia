# Marketing And IT Final Acceptance

## Current Decision: Firebase Only

Reverb and browser WebSocket subscriptions were removed at the user's request.
Stored notifications remain; new realtime delivery uses the shared FirebaseChannel.
No existing jobs were deleted or retried. Previous Reverb evidence is historical,
not the current architecture. See [Firebase Setup](firebase-only-setup.md).
Current regression suite: 50 tests, 223 assertions. Firebase browser receipt still
needs an active token and a controlled delivery check.

## Notification Verification

- Firebase service-account OAuth succeeds; browser tokens and public configuration
  consistency were checked. A controlled Firebase send was requested, but actual
  browser receipt has not been confirmed.
- Reverb is removed and is not a deployment requirement. Existing unrelated jobs
  were not deleted or retried. Scheduled reminders still require the scheduler.

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
| Current PHPUnit suite | PASS: 50 tests, 223 assertions | Isolated SQLite; includes permission seeder idempotency |
| IT product HTTP lifecycle | PASS | Create/update/delete, dependent deletion isolation, validation and restricted-user denial |
| Marketing Quick Links lifecycle | PASS | HTTP create/update/delete, department synchronization, validation, permission denial and rollback on failed synchronization |
| Selected MySQL assertions | PASS: 11 | Deadline schema/rollback, SLA hours, selected report SQL |
| Fresh MySQL installation | PASS: all 681 migrations | Disposable Docker schema, not the shared database |
| DatabaseSeeder | PASS | Disposable Docker schema; external delivery faked |
| Authenticated HTTP smoke | PASS: 33 routes returned 200 | Local admin; list/create forms, reports, calendar and dashboards |
| Local permission audit | PASS: zero missing/unassigned | Three new permissions granted only to Super admin |
| Legacy attachment preview | PASS: zero candidates/errors | Current local test DB only; no production file transfer |
| Scoped 200-line check | PASS | Both domain modules, shared attachment actions and readiness queries |
| Browser interaction/screenshots | NOT VERIFIED | Browser connector unavailable; HTTP checks are not visual checks |
| Complete CRUD and source parity | NOT VERIFIED | HTTP smoke checks do not create/update/delete business records |
| Firebase delivery | PARTIALLY VERIFIED | OAuth/configuration checked; actual browser receipt unconfirmed; no Reverb requirement |
| Original data/file migration | NOT VERIFIED | Empty test attachment preview is not production evidence |

## Changes Made During Acceptance

- Made Quick Links create/update/delete transactional. Updates and deletion lock
  the owner row; failed department synchronization cannot leave a partial write.
- Added isolated HTTP lifecycle tests for IT Products and Marketing Quick Links.
  These checks do not establish lifecycle coverage for every remaining feature.
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
2. Verify controlled Firebase notification receipt in foreground and background,
   with no duplicates. Verify the deployed scheduler and any unrelated queued jobs.
3. Validate representative original records and migrate/retire old public file
   URLs after reviewing dependent applications and backups.
4. Resolve or explicitly accept remaining source layout/PDF differences and
   upload reconciliation behavior after outer rollback/process failure.

Only update this decision after recording evidence for the missing checks.
