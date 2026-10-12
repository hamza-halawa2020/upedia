# Marketing

One domain module with feature folders under `src/`: `Plans`, `Scripts`,
`Complaints`, `QuickLinks`, and `Reports`. Each feature owns its controllers, FormRequests,
Actions, Queries, Filters, and exports.

- Provider: `App\Providers\MarketingModuleServiceProvider`.
- Route entry point: `routes/web.php`; all URLs start with `/marketing`.
- View namespace: `marketing::`; pages live under their feature folder.
- Shared components and layouts stay in the application's `resources/views`.
- Notifications stay in `Modules/Notifications` and are registered separately.
- Shared department lookup: `App\Queries\ListDepartments`.

Reports is registered at `/marketing/reports`, with separated report queries,
filters and builders. Leads/Auth remain staged; authentication is reused from the host.

Plans, Scripts and Complaints share upload storage through
`App/Actions/Attachments/StoreAttachments`. Existing public paths are preserved.
Protected downloads, deletion consolidation, source parity and browser/MySQL
verification are not yet complete. Do not consider the whole domain finished.

Follow `Docs/monolith-migration-plan.md` for every subsequent change.

