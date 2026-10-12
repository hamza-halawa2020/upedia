# Marketing And IT Review

Current target: `D:/hamza/upedia-all`.
Sources remain unchanged: `marketing.upedia` and `it.upedia`.

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
- Preserved append-on-edit behavior, department sync and existing public paths.
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
- Client phone lookup requires marketing_complains_create because it supports complaint creation and exposes client data.
- Assign these existing permission names to intended roles before deployment. Script ownership/department visibility and QuickLink permissions remain unchanged.

## Script Access Regression Coverage

- Tests cover owner access, marketing manager access, Super admin without staff, approved department-only viewing, denial of department editing/deletion, draft visibility and users without staff.
- Existing script authorization behavior is preserved. These action-level tests do not replace browser or full route integration checks.

## Remaining Work

- Move legacy public uploads into private storage and reconcile old database paths.
- Cleanup after outer transaction rollback or commit failure.
- Source-specific PDF visual parity and full browser verification.
- IT scheduled notification and TestTicket workflow parity.
- Complete staff details and view tracking.
- Full dashboard/report visual and behavior parity.
- Provision/assign new permission names.
- Broad regression coverage: previous Feature tests were deleted in the current worktree.
- Browser and MySQL integration validation; live shared database was not modified.

## Verification

Eight focused tests pass (35 assertions): bounded preview, formula non-evaluation,
attachment naming, rollback, solution edit,
authorized download/delete, path containment and actual PDF generation.
PHP syntax and Blade compilation pass.
This is not a full migration sign-off.
