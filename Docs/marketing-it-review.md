# Marketing And IT Review

## Reverb Configuration Update

- Reverb is installed, registered and tested on localhost:8080. A signed synthetic
  broadcast was accepted; private user-channel authorization tests pass.
- New notification broadcasts and local workers use upedia-all-notifications.
  Imported default-queue jobs were not deleted or retried. Missing legacy job
  classes remain the responsibility of their original domains.
- Firebase service-account OAuth succeeds. Browser receipt, HTTPS/WSS and actual
  user push delivery are still unverified. Server configuration is not final sign-off.
- See [Local Reverb Setup](reverb-local-setup.md) for commands and limitations.

Current target: `D:/hamza/upedia-all`.
Sources remain unchanged: `marketing.upedia` and `it.upedia`.

## Acceptance Attempt: 2026-10-12

- Independent local test database confirmed by the user.
- 43 tests pass (178 assertions); all 681 migrations and DatabaseSeeder pass
  in a separate disposable MySQL schema with external delivery disabled.
- Authenticated local HTTP smoke checks pass for 33 routes. These are server
  response checks, not browser interaction or complete CRUD tests.
- Three missing permissions were provisioned for Super admin only, as approved.
  Local audit now reports zero missing/unassigned permissions.
- Local legacy attachment preview has zero candidates; production files remain
  unverified. Firebase/broadcast/queue are not configured, as confirmed by user.
- Final acceptance remains unsigned. See [Acceptance Evidence](marketing-it-final-acceptance.md).

## Latest Verification: 2026-10-12

- Current full suite: 39 tests, 166 assertions. Dedicated MySQL 8 verification:
  11 additional assertions on synthetic records only; shared database untouched.
- MySQL verified DATETIME deadlines, legacy preservation and rollback/reapply,
  SLA hours plus item minutes, reconstruction preview/apply and selected report SQL.
- Legacy attachment migration now has a preview-first command, streamed copies,
  checksum checks and database-error cleanup. Public originals are not deleted.
- A read-only route permission audit reports missing and unassigned permissions;
  no production role grants have been made; approved grants exist on the independent local test DB.
- Ticket manager details, requester-detail form integration, view tracking,
  workload/live metrics, report links/charts and opt-in reminders are implemented.
- Marketing observers are registered after commit. XLSX contents are tested;
  user strings are bound as text rather than executable spreadsheet formulas.
- Complaint lookup permits create OR edit permission; empty validation-error
  arrays no longer suppress AJAX messages. View/edit controls respect permissions.
- Browser runtime setup still fails; visual/interaction sign-off remains pending.
- See [Verification Runbook](marketing-it-verification-runbook.md) for safe steps.

## Implemented In This Review

- Saved XLSX/XLS/CSV files now have inline previews: first sheet, up to 200 data
  rows and 50 columns. Formulas are not evaluated and cells are HTML escaped.
- Preview input is capped at 10 MB; XLSX expanded size is capped at 50 MB.
- `/it/filtered-tables/{filteredTable}/download` offers the full original file.
  Project and path checks are reused for preview and download.

- New uploads are stored on the local private disk, not in public/uploads.
- Shared `/attachments/{attachment}` GET/DELETE routes validate owner permissions.
- Script access uses the existing script authorization action; public/department
  solution downloads reuse the existing visibility query.
- Marketing deletion and IT solution/ticket/purchase deletion use shared file cleanup.
  Files are removed after commit; rollback preserves both rows and files.
- PDF export enabled for five IT exporters, sharing a safe escaped template and
  renderer. PDFs are limited to 1000 rows; filter further rather than truncate.
- Existing legacy public files are supported but remain publicly addressable until
  a separate data/file migration moves them. New upload links use protected routes.

- Consolidated three Marketing upload implementations into one shared action.
- Enabled IT solution, purchase and ticket uploads with FormRequests and multipart forms.
- IT uploads append on edit; Marketing plan uploads replace previous files. Department sync and legacy-path compatibility remain preserved.
- Random file names prevent collisions and avoid trusting client filenames for paths.
- Immediate database/storage errors clean newly written files.
- Corrected Marketing README report registration status.

## Marketing Edit Authorization

- Edit/update now require marketing_plans_edit, matching the UI permission. This closes a source-side authorization gap rather than preserving it.
- Calendar integration tests verify event mapping, filtering, missing staff and a constant two queries for one or twelve plans.

## Marketing Plans Follow-Up

- Calendar filters are separate from queries; event formatting and eager staff loading are preserved.
- Plan pagination keeps active query-string filters.
- Updating plan attachments replaces old files, matching the source.
- Export deliberately reuses listing visibility (including content-creator scope), search and month filters. The source export did not apply all of these restrictions; this is not exact behavior parity.
- Calendar still returns the raw event array required by the existing FullCalendar integration.

## Complaint Authorization Follow-Up

- Complaint CRUD now enforces marketing_complains_index/create/show/edit/destroy. Source middleware was commented out; this is intentional security hardening.
- Client phone lookup requires marketing_complains_create OR marketing_complains_edit; it supports both forms and exposes client data.
- Assign these existing permission names to intended roles before deployment. Script ownership/department visibility and QuickLink permissions remain unchanged.

## Script Access Regression Coverage

- Tests cover owner access, marketing manager access, Super admin without staff, approved department-only viewing, denial of department editing/deletion, draft visibility and users without staff.
- Existing script authorization behavior is preserved. These action-level tests do not replace browser or full route integration checks.

## Plan Listing And Export Query Coverage

- Tests verify content-creator visibility in pagination and export collection, including an explicit foreign creator filter that must return no records.
- Search/combined filters/date aliases and one-sided date bounds are covered.
- Pagination preserves query parameters; reading staff for the page issues no additional queries.
- Generated Marketing XLSX contents now have workbook tests. Browser interactions remain unverified.

## Remaining Work

- Move legacy public uploads into private storage and reconcile old database paths.
- Cleanup after outer transaction rollback or commit failure.
- Source-specific PDF visual parity and full browser verification.
- End-to-end IT reminder delivery and scheduler operation; shared delivery is implemented but external delivery is unverified.
- Verify requester-details interaction and ticket view tracking in browsers; backend regression tests pass.
- Full dashboard/report visual and behavior parity.
- Review restricted-role mappings beyond the approved Super admin-only new grants.
- Broad regression coverage: previous Feature tests were deleted in the current worktree.
- Browser and broader MySQL integration coverage; selected MySQL assertions pass and the shared database was not modified.

## Verification

43 tests pass (178 assertions), plus 11 isolated MySQL assertions. All 681 migrations and DatabaseSeeder pass in a separate disposable schema.
Previous Blade compilation passed. Scoped 200-line checks pass.
Browser, external delivery and live rollout remain unverified.
This is not a full migration sign-off.
