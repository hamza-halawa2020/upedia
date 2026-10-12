# IT

Domain migration from `D:/hamza/it.upedia` into `D:/hamza/upedia-all`.

- One provider: `App\Providers\ITModuleServiceProvider`.
- One route entry point: `routes/web.php`; `/it` URLs and `it.*` names.
- One view namespace: `it::`.
- Features live in `src/{Feature}` with Actions, Queries, Filters and FormRequests.
- Reuse shared models, components, authentication and Notifications.
- Code and view files stay below 200 lines.

Migrated:

- Products: CRUD, search, permissions, notifications, dependent asset deletion.
- Vendors: CRUD, search, pagination, permissions, notifications, Excel/CSV export,
  transactional bulk deletion of dependent assets/accessories.

Products use `App\Models\ItProduct`, not the CRM Product model.
Vendor exports reuse listing filters and stream query chunks through Laravel Excel.
Notification delivery stays in `Modules/Notifications`.

Pending: vendor PDF/saved tables, ticket configuration, Tickets, Assets,
Purchases/Expenses, Solutions, saved filters, dashboards/reports, notification config.

Verification: 16 tests, 102 assertions on isolated SQLite, PHP/file-size checks,
route registration and Blade compilation. Browser interaction checks remain pending.
Composer audit reports existing Laravel framework advisories requiring separate review.

See `Docs/monolith-migration-plan.md` for mandatory rules and migration progress.
