# Marketing

One domain module with feature folders under `src/`: `Plans`, `Scripts`,
`Complaints`, and `QuickLinks`. Each feature owns its controllers, FormRequests,
Actions, Queries, Filters, and exports.

- Provider: `App\Providers\MarketingModuleServiceProvider`.
- Route entry point: `routes/web.php`; all URLs start with `/marketing`.
- View namespace: `marketing::`; pages live under their feature folder.
- Shared components and layouts stay in the application's `resources/views`.
- Notifications stay in `Modules/Notifications` and are registered separately.
- Shared department lookup: `App\Queries\ListDepartments`.

`Reports`, `Leads`, and `Auth` contain staged code from the original migration;
their routes are not enabled until they satisfy the migration checklist.

Follow `Docs/monolith-migration-plan.md` for every subsequent change.

