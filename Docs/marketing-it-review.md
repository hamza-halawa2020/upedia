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
