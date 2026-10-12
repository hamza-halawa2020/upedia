# Marketing And IT Final Acceptance

## Current Decision: Firebase Only

Reverb and browser WebSocket subscriptions were removed at the user's request.
Stored notifications remain; new realtime delivery uses the shared FirebaseChannel.
No existing jobs were deleted or retried. Previous Reverb evidence is historical,
not the current architecture. See [Firebase Setup](firebase-only-setup.md).
Current regression suite: 61 tests, 1106 assertions, plus five isolated JavaScript
service-worker checks. The user confirmed foreground reception, then background
display exactly once with the correct notification-page link on 2026-10-12.

## Notification Verification

- Firebase service-account OAuth succeeds; browser tokens and public configuration
  consistency were checked. Foreground receipt was confirmed by the user.
- Initial background acceptance failed. Corrected malformed local APP_URL values,
  enabled immediate service-worker activation, and made HTTP v1 web push data-only
  so the shared worker owns display. The user confirmed the final background
  notification appeared once and opened the correct page.
- Reverb is removed and is not a deployment requirement. Existing unrelated jobs
  were not deleted or retried. Scheduled reminders still require the scheduler.

Date: 2026-10-12. Target: `D:/hamza/upedia-all`.
Local test URL: `https://upedia-all.test`.

## Decision

**Scope confirmed by the user: code acceptance in the new project only.**
Production data/file transfer, retirement of the source applications and production
deployment approval are explicitly out of scope, not blockers for this decision.

**Code acceptance remains unsigned.** The checks below pass, including controlled
Firebase delivery, but do not establish complete workflow and browser interaction
parity for every feature.

The user confirmed the local project has an independent test database and
approved assigning the three new permissions to Super admin only.
No login password is stored in the verification scripts or documentation.

## Evidence

| Check | Result | Scope |
| --- | --- | --- |
| Current PHPUnit suite | PASS: 61 tests, 1106 assertions | Isolated SQLite; includes structural route coverage, not full browser CRUD |
| Source business route coverage | PASS | Both domains' resource and special endpoints, resolvable actions, static matching and no duplicate module method/URI pairs |
| Firebase service-worker checks | PASS: 5 | Isolated JavaScript mocks; display ownership, stable tag, click order, URL safety and existing-window focus |
| IT product HTTP lifecycle | PASS | Create/update/delete, dependent deletion isolation, validation and restricted-user denial |
| Marketing Quick Links lifecycle | PASS | HTTP create/update/delete, department synchronization, validation, permission denial and rollback on failed synchronization |
| IT vendor HTTP lifecycle | PASS | Create/update/delete, isolation of dependent deletion, invalid input preservation and restricted-user denial |
| Marketing plan HTTP lifecycle | PASS | Create/update/delete, staff ownership, input validation and atomic rollback on attachment failure |
| Permission-guarded domain endpoints | PASS: 96 requests denied | Ungranted authenticated user; permission middleware now precedes route model binding |
| Selected MySQL assertions | PASS: 11 | Deadline schema/rollback, SLA hours, selected report SQL |
| Fresh MySQL installation | PASS: all 681 migrations | Disposable Docker schema, not the shared database |
| DatabaseSeeder | PASS | Disposable Docker schema; external delivery faked |
| Authenticated HTTP smoke | PASS: 33 routes returned 200 | Local admin; list/create forms, reports, calendar and dashboards |
| Local permission audit | PASS: zero missing/unassigned | Three new permissions granted only to Super admin |
| Legacy attachment preview | PASS: zero candidates/errors | Current local test DB only; no production file transfer |
| Scoped 200-line check | PASS | Both domain modules, shared attachment actions and readiness queries |
| Browser interaction/screenshots | NOT VERIFIED | Browser connector unavailable; HTTP checks are not visual checks |
| Complete CRUD and source parity | NOT VERIFIED | HTTP smoke checks do not create/update/delete business records |
| Firebase delivery | PASS: local controlled test | User confirmed foreground receipt and background display once with working link; no Reverb requirement |
| Original data/file migration | OUT OF SCOPE | User requested code acceptance only; no retirement or production transfer authorized |

## Changes Made During Acceptance

- Made Quick Links create/update/delete transactional. Updates and deletion lock
  the owner row; failed department synchronization cannot leave a partial write.
- Added isolated HTTP lifecycle tests for IT Products and Marketing Quick Links.
  These checks do not establish lifecycle coverage for every remaining feature.
- Corrected the local APP_URL to include HTTPS. Changed web push to data-only,
  prevented manual redisplay of Firebase-managed notification payloads, activated
  worker updates immediately, and normalized click URLs with unsafe-scheme fallback.
- Added vendor and marketing-plan HTTP lifecycle tests. Made plan creation and
  attachment storage share a transaction so upload failure leaves no saved plan
  or created notification. Permission checks now run before route model binding.
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
2. Verify local scheduled workflows as part of feature acceptance. Local foreground
   and background Firebase receipt is already accepted. Unrelated domains' jobs
   and production infrastructure are outside this code migration's acceptance.
3. Resolve or explicitly accept remaining source layout/PDF differences and
   upload reconciliation behavior after outer rollback/process failure.

Browser acceptance still needs actual form interactions for ticket requester lookup,
closure/reopening, asset accessory replacement, purchase/expense state transitions,
script/complaint attachments and department visibility, calendar filters, reports,
and saved-table preview/restore. Structural route checks do not cover these flows.

Only update this decision after recording evidence for the missing checks.

The source IT's ad hoc test-mail and unrestricted notification send/broadcast
endpoints are not domain migration requirements. Authentication and notification
configuration/read/token operations belong to the shared application. Shared
administrative sending needs explicit authorization, not copied legacy routes.
