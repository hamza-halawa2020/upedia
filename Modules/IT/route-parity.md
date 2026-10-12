# IT Route Migration Inventory

Source: `D:/hamza/it.upedia/routes/web.php`.
Target: `D:/hamza/upedia-all/Modules/IT/routes/web.php`.
Every migrated URL is prefixed with `/it`; route names with `it.`.
This inventory is not a claim that the domain migration is complete.

## Registered

- `/products`: resource routes.
- `/vendors`: resource routes and `/vendors/export` (Excel/CSV).
- `/ticket-items`, `/ticket-categories`, `/ticket-priorities`: resource routes,
  sharing the ticket configuration implementation without duplicate CRUD logic.
- `/solutions`, `/solutions/{id}`: visibility-controlled browsing.
- `/it-solutions`: administration resource; attachment upload/download/deletion
  remains pending. Deletion is blocked for solutions with existing attachments.

## Pending Controller And Workflow Migration

- `/filtered-tables`: index, restore, destroy and view.
- `/purchase`: resource, export and save-filtered-table.
- `/expenses`: resource, export and save-filtered-table.
- `/asset`: resource, export and save-filtered-table.
- `/tickets`: resource, export and save-filtered-table.
- `/tickets/staff-by-department/{departmentId}`.
- `/tickets/staff-search` and `/tickets/staff-details/{staffId}`.
- `/vendors/save-filtered-table` and PDF export.
- `/`: IT dashboard.
- `/statistics` and `/asset-dashboard`.
- POST `/updateStatus` and `/updateStatus/purchase`.
- `/reports`.

Do not register these against missing classes or placeholder success responses.
Implement their Actions, Queries, Filters, FormRequests, permissions, views and
tests first. Preserve original route paths and methods when enabling them.
Special export/search routes must precede resource wildcard routes.

## Excluded From IT

- All `/notifications` routes: reuse the shared Notifications module.
- `/firebase-configs`: notification configuration belongs to Notifications.
- `/logout`: reuse host authentication rather than copying login/session logic.
- `/test-mail`: source development diagnostic, not a production feature.

## Verification

Full source/target route parity is pending the workflows listed above.
Existing registrations must continue passing route-list and focused tests.
