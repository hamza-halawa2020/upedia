# Upedia Modular Monolith Migration Plan

## Goal

Move the active Upedia Laravel applications into `D:/hamza/upedia-all` as one modular Laravel 11 project, while keeping the current apps running until each module is fully migrated and verified.

## IT Migration Progress

- Ticket resource/export/saved-table and all three staff lookup routes are now
  registered under `/it/tickets`. Staff API success responses use the shared
  responder with `data`; endpoints require ticket creation permission.
- Ticket closure/reopening tracks `closed_at` and `reopen_count` transactionally.
- Business deadlines skip Friday/Saturday and respect notification configuration
  working hours. Invalid working-hour windows are rejected rather than looping.
- Source `sla_hours` is treated as minutes for compatibility; confirm intended
  units before a separate data/behavior migration. Zero SLA clears old deadlines.
- Ticket attachments, PDF, scheduled notifications, view tracking, manager detail
  lookup and TestTicket-specific workflow migration remain pending.
- Staff-details currently returns name, department and phone, not manager_name.
- New forms use the unified API envelope; consumers of the old raw staff arrays
  must read `data`. Full browser interaction verification remains pending.

- Asset resource, Excel/CSV export and saved-table routes now exist under `/it/asset`.
- Canonical `App/Models/Asset` reuses IT product mapping and now provides
  department/vendor/accessory relationships plus aggregate total cost.
- Accessory replacement uses bulk writes inside a transaction. Form submissions
  explicitly indicate the empty accessory set so removing the last item persists.
- PDF, asset dashboard, actor notifications and browser verification remain pending.

- Expense resource, Excel/CSV export and saved-table creation are registered
  under `/it/expenses`. `Modules/IT/Expenses/Models/ItExpense` owns `expenses`;
  the shared finance `App/Models/Expense` continues to own `sm_add_expenses`.
- Petty-cash writes and finance expense creation share a transaction. Paid IT
  expenses cannot be edited/deleted; status is not accepted from ordinary forms.
- Purchases/Expenses reuse `SavedTables/Actions/SaveExportTable`.
- Expense approval/status endpoint, PDF export and actor notifications remain
  pending. Financial posting follows existing source behavior, not a new ledger design.

- Purchases resource is registered under `/it/purchase`, with `/export` and
  `/save-filtered-table` registered before the resource wildcard.
- Pending-only create/update workflows calculate item tax and shipping, insert
  details in bulk and synchronize requester/vendors inside a transaction.
- Export supports Excel/CSV and saved Excel tables; listing/export share filters.
- PDF, purchase attachments and approval/status transitions remain pending.
  Attached, invoiced or non-pending purchases cannot currently be deleted.
- Source behavior intentionally tightened: clients cannot change status through
  ordinary edits; item amounts are rounded to two decimal places.
- Focused purchase tests pass (3 tests, 22 assertions).

- Saved-table index, restore, view/download and destroy routes are registered
  under `/it/filtered-tables`. Queries enforce `project = it`; file access is
  restricted to the public disk's `filtered_tables` directory.
- Restore only targets registered IT routes and permits known filter keys.
- Excel/CSV saved files currently download instead of rendering an inline preview;
  saved-table creation and bounded spreadsheet preview remain pending.
- File removal runs after database commit; filesystem cleanup failures still
  require operational handling/retry rather than a distributed transaction.

- Solution administration is registered under `/it/it-solutions`: create, edit,
  list, detail, department visibility and deletion of attachment-free solutions.
- Each administration operation requires its `it_solutions_*` permission.
- Existing attachments are preserved on edits. Upload/download/file deletion
  migration remains pending; deleting an attached solution is temporarily blocked.
- Ticket configuration is migrated with explicit resources and independent controllers.
- Verification after solution administration: 27 isolated tests, 178 assertions;
  Blade compilation passed. Files in the solution feature are below 200 lines.

- Active project root: `D:/hamza/upedia-all`; application classes live in `app/`.
- IT Products migrated into `Modules/IT/src/Products` with `/it/products`
  URLs and `it.products.*` route names.
- Reuse shared `ItProduct`, `Asset`, and `AssetAccessory` models and UI components.
- Notification delivery uses shared `Modules/Notifications/src/Actions/NotifyActor.php`.
- Focused FormRequests, Actions, Queries, and Filters; files below 200 lines.
- Dependent deletion is transactional and bulk-based to avoid N+1 queries.
- Vendors CRUD, search, pagination, Excel/CSV export, permissions, and actor
  notifications migrated. Dependent asset deletion is transactional and bulk-based.
- Vendor PDF export and saved filtered tables remain pending shared export infrastructure.
- Excel's declared dependency is now installed and locked; Symfony String remains
  on its original version. Composer audit reports four existing Laravel framework
  advisories; plan a separate supported-framework upgrade before production rollout.
- Isolated tests use `http://localhost`; development `APP_URL` must include its scheme.
- Verified in the new project: 16 isolated IT tests, 102 assertions, registered
  product/vendor routes, compiled Blade templates, PHP syntax and 200-line checks.
- Full browser interaction checks remain pending.
- Next: ticket configuration, Tickets, Assets, Purchases/Expenses,
  Solutions, saved filters, dashboards/reports, notification configuration.
- Original applications remain unchanged. Products and the above Vendors scope are migrated.

The target architecture is a modular monolith:

- One Laravel application.
- One database owner for migrations and seeders.
- One auth/session implementation.
- Shared core models for common tables.
- Domain modules for business areas, with feature folders inside each domain.

## Projects In Scope

The old `upedia` folder is not part of this migration.

Projects in scope:

1. `setting.upedia`
2. `marketing.upedia`
3. `it.upedia`
4. `academic.upedia`
5. `exam.upedia`
6. `finance.upedia`
7. `hr.upedia`
8. `crm.upedia`
9. `retention.upedia`
10. `upedia-student`

## Current Finding

Most apps are Laravel 11 and already share the same database concepts. Many core models are duplicated across apps, such as:

- `User`
- `Staff`
- `Student`
- `SmHumanDepartment`
- `Tab`
- `Track`
- `TrackType`
- `AcademyProduct`
- `Attachment`

This means the apps are not truly independent services. They are closer to modules around the same data model, so a modular monolith is a reasonable target.

## Target Module Layout

```text
Modules/
  Notifications/
  Marketing/
    src/
      Plans/
      Scripts/
      Complaints/
      QuickLinks/
      Reports/
    resources/views/
      plans/
      scripts/
      complaints/
      quick-links/
      reports/
    routes/
      web.php
    Providers/
      MarketingModuleServiceProvider.php
  IT/
  Requests/
  Finance/
  HR/
  CRM/
  Retention/
  Academic/
  Exam/
  Student/
```

The migration should be domain-based at the module level and feature-based inside each domain module.

For example, marketing is one domain module, but plans, scripts, complaints, quick links, and reports stay separated inside it.

Notifications must not be copied into every domain. They belong in one shared `Notifications` module and all other modules should use it.

Do not create separate root modules for small features that belong to the same domain.

```text
Avoid:
Modules/MarketingPlans
Modules/Scripts
Modules/Complaints
Modules/QuickLinks
```

Use:

```text
Modules/Marketing/
  routes/web.php
  resources/views/plans/
  resources/views/scripts/
  resources/views/complaints/
  resources/views/quick-links/
  src/Plans/
  src/Scripts/
  src/Complaints/
  src/QuickLinks/
```

Shared/common code should stay in the main app:

```text
app/Models/User.php
app/Models/Staff.php
app/Models/Student.php
app/Models/SmHumanDepartment.php
app/Models/Tab.php
app/Models/Attachment.php
database/migrations/
database/seeders/
```

Shared UI components must also stay outside feature modules when they are used across the project:

```text
resources/views/components/
resources/views/layouts/
resources/views/partials/
```

Feature modules may have private views and private partials, but they must not keep copies of general components such as:

- alerts
- breadcrumbs
- page titles
- table controls
- table actions
- pagination shells
- status badges
- upload widgets
- shared form fields

If a component can be used by more than one module, move it to the shared app components folder and reference it from there.

## Migration Order

Start with the smallest and lowest-risk systems, then move to the bigger operational systems.

1. `marketing.upedia`
2. `it.upedia`
3. `exam.upedia`
4. `academic.upedia`
5. `finance.upedia`
6. `hr.upedia`
7. `crm.upedia`
8. `retention.upedia`
9. `upedia-student`

`D:/hamza/upedia-all` is the host/core app; `setting.upedia` is the old source.

## Rules During Migration

These rules are mandatory. No migration task is considered done unless it follows this file.

1. Read and apply this document before implementing any migration task.
2. Do not delete or modify the original projects during migration.
3. Do not duplicate core models unless a module has real module-specific behavior.
4. Do not duplicate business logic, queries, validation, Blade components, helpers, or services. Reuse or extract shared code first.
5. Migrations and shared seeders live only in `D:/hamza/upedia-all`.
6. Root modules are organized by domain/business area.
7. Features inside a domain are organized in separate folders.
8. Do not create a root module for every small feature if those features belong to the same domain.
9. Each domain module gets one service provider and one route entry point.
10. Each domain module gets one view namespace.
11. Move one feature at a time inside the domain module.
12. After each feature, run syntax checks and route checks before moving to the next one.
13. Keep current URLs working by adding redirects or aliases when needed.
14. Shared features, such as notifications, files, auth, comments, approvals, and reusable UI components, must be implemented once and reused.

## Route Prefix Rules

Routes migrated from an old project must keep that project as their URL prefix.

Marketing routes must always start with `/marketing`.

Examples:

```text
/marketing/plans
/marketing/scripts
/marketing/complains
/marketing/quick-links
```

Even when the code is split into feature folders like `Plans`, `Scripts`, `Complaints`, and `QuickLinks`, the URL prefix stays `/marketing`.

This keeps URLs grouped by product area while the code stays grouped by feature.

Shared modules do not use a product prefix unless they are mounted inside a product area.

Examples:

```text
/notifications
/attachments
```

Route names can remain compatible with the old app when needed, but URLs must be explicitly prefixed.

## Code Size And Maintainability Rules

Marketing reports now live in `Modules/Marketing/src/Reports`:

- `Services/MarketingReportService`: orchestration only (55 lines).
- `Queries/ReportData`: database reads with eager-loaded staff relationships.
- `Filters/ReportDateRange`: date parsing and range normalization.
- `Builders`: Summary, Breakdowns, Trends, Sections, Metrics, Charts, and Links.
- `Http/Requests/MarketingReportRequest`: validated date inputs.
- `App/Services/MarketingReportService` remains a thin compatibility adapter,
  not a second implementation.
- Every extracted class is below 200 lines. Regression tests cover report shape,
  calculations, date ordering, defaults and query-free presentation building.
- A one-time comparison verified the full populated report output matches the
  original service. Existing query scope and eager loading were preserved.
- SQL aggregation/streaming for very large reporting datasets remains future work;
  this refactor does not change the existing in-memory reporting strategy.

The new monolith must be easy to edit and maintain. Large files are not allowed by default.

## Architecture Pattern

Ticket configuration uses explicit resource routes and independent
`TicketCategoryController`, `TicketItemController`, and `TicketPriorityController`,
each with its own FormRequest. Do not generate domain routes through a catalog loop
or choose validation rules from route defaults. Share only genuinely common
Actions/Queries and view structure. The internal Catalog enum remains a typed
selector for those existing shared classes, not an HTTP routing mechanism.

Use a feature-first modular monolith with use-case classes.

Default backend flow:

```text
Route
  -> Controller
  -> FormRequest
  -> Action or Query
  -> Model/Repository when needed
  -> Resource/View/Redirect
```

### Class Roles

- Controller: HTTP only. No business logic.
- FormRequest: authorization and validation only.
- Action: one write use-case, for example `CreateMarketingPlan`.
- Query: one read/listing use-case, for example `ListMarketingPlans`.
- Filter: applies request filters/search/sort to an Eloquent query.
- Service: orchestration only when one workflow coordinates multiple actions or external integrations.
- DTO: typed data object when arrays start getting passed between layers.
- Exporter/Importer: file import/export logic.
- NotificationBuilder: builds notification payloads; delivery stays in the notifications module.

Prefer small Actions/Queries over large Services. A service is allowed only when it genuinely coordinates a workflow.

Filtering, searching, and sorting must stay outside services/actions.

Do not put filter chains inside services:

```php
// Avoid this inside services
$query->when($request->status, fn ($q) => $q->where('status', $request->status));
```

Use a dedicated filter class or query class inside the feature folder instead:

```text
Modules/Marketing/src/Plans/
  Queries/ListMarketingPlans.php
  Filters/MarketingPlanFilters.php
```

The query class owns the read use-case. The filter class owns all filter rules.

```php
// Query
$query = MarketingPlan::query();
$query = $filters->apply($query, $criteria);

return $query->latest()->paginate();
```

```php
// Filter
public function apply(Builder $query, array $criteria): Builder
{
    return $query
        ->when($criteria['status'] ?? null, fn ($q, $status) => $q->where('status', $status))
        ->when($criteria['search'] ?? null, fn ($q, $search) => $q->where('title', 'like', "%{$search}%"));
}
```

### N+1 Query Rule

N+1 queries are not allowed.

Any feature that lists records must define required relationships in its Query class using eager loading:

```php
MarketingPlan::query()
    ->with(['staff', 'attachments'])
    ->latest()
    ->paginate();
```

Do not load relationships implicitly inside Blade loops, export loops, API resources, notifications, or collection maps.

Avoid this:

```php
@foreach ($plans as $plan)
    {{ $plan->staff->name }}
@endforeach
```

unless the Query class already has:

```php
->with('staff')
```

For counts, use `withCount()` instead of counting loaded relations in a loop:

```php
Ticket::query()->withCount('replies')->paginate();
```

For sums/aggregates, use `withSum()`, `selectSub()`, or a dedicated aggregate query instead of looping and querying per row.

During local development, enable lazy-loading prevention where possible:

```php
Model::preventLazyLoading(! app()->isProduction());
```

Each feature checklist must include an N+1 review:

- check Blade loops
- check API Resources
- check exports
- check notifications
- check nested relationships
- check dashboard cards/statistics
- check policies/gates that access relations in loops

If a relation is optional but displayed in a list, eager load it anyway.

Example:

```text
Modules/Notifications/src/
  Http/Controllers/NotificationController.php
  Http/Requests/StoreDeviceTokenRequest.php
  Actions/ListUserNotifications.php
  Actions/MarkNotificationAsRead.php
  Actions/MarkAllNotificationsAsRead.php
  Actions/StoreDeviceToken.php
```

### Hard Limits

- Controllers: max 200 lines.
- Services: max 200 lines.
- Actions/jobs/listeners: max 200 lines.
- Form requests: max 200 lines.
- Blade pages/components: max 200 lines.
- JavaScript/TypeScript files: max 200 lines.
- CSS files: max 200 lines.

If a file needs to exceed 200 lines, it must be split first unless there is a clear documented reason.

### Backend Structure

Controllers should only handle HTTP concerns:

- Read the request.
- Call a service/action.
- Return response/view/redirect.

Controllers should not contain business logic, large queries, export logic, notification logic, or file handling logic.

Validation must use Laravel Form Request classes. Do not keep validation arrays inside controllers except for very small temporary migration code that will be removed before enabling the feature.

Example:

```text
Modules/Notifications/src/Http/Requests/StoreDeviceTokenRequest.php
Modules/Marketing/src/Plans/Http/Requests/StoreMarketingPlanRequest.php
Modules/Marketing/src/Plans/Http/Requests/UpdateMarketingPlanRequest.php
```

Helpers are allowed only for small pure utilities:

- formatting values
- normalizing strings
- simple array/date transformations
- functions with no database, auth, request, session, files, queues, or external APIs

All helpers are public project-level helpers. A helper must be reusable across the whole application, not private to one module or one screen.

Feature-specific helper logic is not allowed in `app/helpers.php`. Put it inside the owning feature as an Action, Query, Value Object, DTO, or small Service.

Do not put business logic in `app/helpers.php`.

Any helper that uses models, queries, `Auth`, `Request`, sessions, files, payments, notifications, or external APIs must become a service/action inside the relevant feature module.

If a helper grows beyond 20-30 lines, split it into a service/action even if it is currently pure.

Services should contain business workflows, but they should stay small. If a service approaches 200 lines, split it into smaller classes:

- `Actions`
- `Queries`
- `Exporters`
- `Importers`
- `NotificationBuilders`
- `Validators`
- `DTOs`

Example:

```text
Modules/Marketing/src/Plans/
  Http/Controllers/MarketingPlanController.php
  Http/Requests/ListMarketingPlansRequest.php
  Services/MarketingPlanService.php
  Actions/CreateMarketingPlan.php
  Actions/UpdateMarketingPlan.php
  Queries/ListMarketingPlans.php
  Filters/MarketingPlanFilters.php
  Exporters/MarketingPlansExporter.php
```

### Frontend And Blade Structure

Blade pages should stay thin.

If a page grows, split it into:

- layout
- filters partial
- table partial
- form partial
- modal partial
- row/action components

Example:

```text
Modules/Marketing/resources/views/plans/
  index.blade.php
  partials/filters.blade.php
  partials/table.blade.php
  partials/form.blade.php
  components/status-badge.blade.php
```

No page should mix heavy business decisions, queries, and UI markup.

### Shared Feature Rule

If the same logic appears in more than one feature, it should become a shared module or shared service.

Examples:

- Notifications -> `Modules/Notifications`
- Attachments/files -> `Modules/Attachments`
- Employee requests -> `Modules/Requests`
- Permissions/sidebar tabs -> `Modules/AccessControl`
- Exports/imports -> shared exporter classes or feature-local exporters

### Unified API Response Rule

API responses must have one consistent shape across all modules.

Do not return random response structures from controllers or actions.

Use a shared responder, for example:

```text
app/Support/Api/ApiResponse.php
```

Standard success response:

```json
{
  "success": true,
  "message": "Done successfully.",
  "data": {}
}
```

Standard error response:

```json
{
  "success": false,
  "message": "Something went wrong.",
  "errors": {}
}
```

Standard paginated response:

```json
{
  "success": true,
  "message": "Data retrieved successfully.",
  "data": [],
  "meta": {
    "current_page": 1,
    "per_page": 15,
    "total": 100,
    "last_page": 7
  }
}
```

Validation errors should follow the same error shape:

```json
{
  "success": false,
  "message": "Validation failed.",
  "errors": {
    "email": ["The email field is required."]
  }
}
```

Controllers should use shared response helpers/classes:

```php
return ApiResponse::success($data, 'Created successfully.');
return ApiResponse::error('Not found.', status: 404);
return ApiResponse::paginated($paginator);
```

Rules:

- No controller should hand-build API response arrays.
- No module should invent its own response format.
- HTTP status codes must match the response meaning.
- API Resources can format entities, but the envelope must stay unified.
- Exceptions should be rendered into the same error shape.
- Validation responses should be customized globally or through a base FormRequest if needed.

## Per-Feature Checklist

For each feature:

1. Inventory composer dependencies.
2. Inventory routes.
3. Identify the target domain module and feature folder.
4. Identify unique controllers.
5. Identify unique models.
6. Identify shared models that must be reused from `app/Models`.
7. Copy feature views into the domain module view folder.
8. Move controllers into the domain feature namespace.
9. Update controller namespaces and model imports.
10. Update view references.
11. Register routes in the domain module route file.
12. Register only one service provider for the domain module.
13. Run syntax checks.
14. Run `php artisan route:list`.
15. Open the main pages and fix missing dependencies/assets.
16. Check every touched file is below 200 lines.
17. Split any oversized file before moving to the next feature.
18. Check API responses use the unified response shape.
19. Check no copied shared Blade components remain inside the feature module.
20. Check no duplicated business logic or duplicated query/filter/validation code was introduced.
21. Extract repeated logic into shared actions, queries, services, or app-level components before marking the task complete.
22. Check any helper usage is public, reusable, pure, and project-level. Move feature-specific helpers into the feature module.

## First Domain Module

The first shared module is:

1. `Notifications`

Then migrate `marketing.upedia` into one domain module:

```text
Modules/Marketing/
  routes/web.php
  resources/views/
    dashboard/
    plans/
    scripts/
    complaints/
    quick-links/
    reports/
  src/
    Dashboard/
    Plans/
    Scripts/
    Complaints/
    QuickLinks/
    Reports/
```

Marketing features:

1. `Plans`
2. `Scripts`
3. `Complaints`
4. `QuickLinks`
5. `Reports`

Marketing is still a good starting project because it is the smallest app:

- Few controllers.
- Few models.
- No migrations in its own project.
- Mostly dashboard CRUD pages.

But it must not become one flat, large `Marketing` folder with mixed controllers, services, views, and routes.

It also must not be split into many root modules. The correct structure is one `Marketing` domain module with separated feature folders inside it.

Initial implementation steps:

1. Create `Modules/Notifications`.
2. Move shared notification routes/controller/view into `Modules/Notifications`.
3. Create or normalize `Modules/Marketing`.
4. Register one `MarketingModuleServiceProvider`.
5. Register all marketing routes in `Modules/Marketing/routes/web.php`.
6. Move `Plans` into `Modules/Marketing/src/Plans` and `Modules/Marketing/resources/views/plans`.
7. Split oversized services/actions before enabling the feature.
8. Move `Scripts` into `Modules/Marketing/src/Scripts`.
9. Move `Complaints` into `Modules/Marketing/src/Complaints`.
10. Move `QuickLinks` into `Modules/Marketing/src/QuickLinks`.
11. Move `Reports` into `Modules/Marketing/src/Reports`.
12. Remove temporary root feature modules after their code is merged into `Modules/Marketing`.

Current migration status:

- `Notifications`: moved into a shared module.
- `Marketing`: normalized into one domain module. `Plans`, `Scripts`, `Complaints`,
  and `QuickLinks` live under `Modules/Marketing/src/{Feature}` and use
  `marketing::{feature}.*` views.
- Marketing routes are registered once in `Modules/Marketing/routes/web.php`,
  through `App\Providers\MarketingModuleServiceProvider`. Existing route names
  are preserved. Routes use the host application's `sso.token` and `auth`
  middleware; obsolete source-app middleware aliases are not carried over.
- Temporary root feature code, routes, providers, and duplicate staging pages
  have been removed. Future work belongs inside the owning domain module.
- Notifications remain independent in `Modules/Notifications`, with their own
  provider and `/notifications` routes. Do not add notification controllers or
  copies of notification views to Marketing. The duplicate host route registration
  has been removed.
- Shared department lookup lives in `App\Queries\ListDepartments`.
- Large migrated Blade pages have been split into page-local partials. Shared
  layouts and components remain in the host app.
- Reports, Leads, and Auth still contain staged migration code. Their routes are
  not enabled; finish their service/query/validation review before enabling them.
- Runtime verification is pending: run `composer dump-autoload`,
  `php artisan route:list --path=marketing`, and `php artisan view:cache` in an
  environment with PHP and Composer before declaring marketing fully verified.

Feature-specific models:

   - `MarketingPlan`
   - `Script`
   - `Complain`
   - `QuickLink`

Shared models reused from the host app:

   - `User`
   - `Staff`
   - `Student`
   - `Lead`
   - `Tab`
   - `Attachment`
   - `SmHumanDepartment`

## Risk Notes

The biggest risk is not Laravel compatibility. The biggest risk is duplicated business logic and slightly different copies of the same model across apps.

Before moving a large module like HR, CRM, Retention, or Finance, compare duplicated model methods carefully and merge behavior into the canonical shared model.

## Rollback Strategy

Because the old projects are left untouched:

- A module can be disabled by removing its service provider.
- Traffic can continue going to the old project until the migrated module is ready.
- We can migrate URLs one domain at a time.

