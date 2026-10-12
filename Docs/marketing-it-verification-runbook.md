# Marketing And IT Verification Runbook

## Reverb Configuration Update

- Reverb is installed, registered and tested on localhost:8080. A signed synthetic
  broadcast was accepted; private user-channel authorization tests pass.
- New notification broadcasts and local workers use upedia-all-notifications.
  Imported default-queue jobs were not deleted or retried. Missing legacy job
  classes remain the responsibility of their original domains.
- Firebase service-account OAuth succeeds. Browser receipt, HTTPS/WSS and actual
  user push delivery are still unverified. Server configuration is not final sign-off.
- See [Local Reverb Setup](reverb-local-setup.md) for commands and limitations.

Target: `D:/hamza/upedia-all`. Do not run deployment steps against the shared
database until a backup, role mapping and rollout approval are available.

## Verified On 2026-10-12

- Full current PHPUnit suite: 43 tests, 178 assertions, isolated SQLite.
- Dedicated MySQL 8 container: 11 assertions covering deadline DATETIME type,
  legacy TIME preservation, migration rollback/reapply, SLA hours plus item
  minutes, deadline reconstruction preview/apply and selected report SQL.
- New legacy attachment migration tests cover preview, checksum-preserving copy,
  original retention, repeat runs, invalid paths and failed database cleanup.
- Read-only permission audit tests cover required route permissions and no writes.
- Scoped physical-line scan found no files over 200 lines in either domain module,
  shared attachment actions or readiness queries.
- All 681 migrations and DatabaseSeeder now pass in a second disposable schema. This does not verify every workflow or MySQL query.

## Repeat Isolated Verification

The dedicated Docker container is `upedia-verification-20261012`, labeled
`upedia.purpose=isolated-verification`. It exposes MySQL only on localhost:33307.
Its database contains disposable synthetic records, not a copy of production.
The container is stopped after verification; Docker Desktop remains running.

```powershell
docker start upedia-verification-20261012
php tests/Integration/VerifyIsolatedMysql.php --reset
php artisan test
docker stop upedia-verification-20261012
```

`--reset` removes tables only from the fixed disposable verification database,
after verifying its identity and marker. The verifier overrides database
configuration in-process; it does not rewrite `.env`.

## Staging Rollout

1. Use a separate staging database and backed-up file tree. Keep
   `IT_TICKET_REMINDERS_ENABLED=false`.
2. Apply the new deadline migration in staging. It renames the original TIME
   column to `legacy_resolution_time` and adds nullable DATETIME `resolution_time`.
3. Preview reconstructed deadlines, then apply only after reviewing sample records:

```powershell
php artisan it:tickets:rebuild-deadlines
php artisan it:tickets:rebuild-deadlines --apply
```

Priority `sla_hours` is hours, as confirmed by the user. Item resolution values
remain minutes. The command only reconstructs missing deadlines; it does not
overwrite existing non-null values. Validate existing values separately.

4. Audit permissions without granting access automatically:

```powershell
php artisan migration:audit-permissions
```

Missing permissions and permissions without role assignments cause a nonzero
exit. Direct user grants are not included in role counts. Agree on the intended
role map before assigning permissions; do not grant every permission to everyone.

5. Preview legacy attachments, then copy and update paths in staging:

```powershell
php artisan attachments:migrate-private
php artisan attachments:migrate-private --apply
```

Both commands report missing/invalid files. Application mode streams each file,
checks SHA-256 and commits its new private path. Public originals are intentionally
retained. Existing scripts, URLs and sibling projects may still use them.
Only disable public serving/remove originals after those consumers and backups
are reviewed. Copying files alone does not remove public access.

6. Exercise permissions, CRUD, attachments, calendar, filter pagination, exports,
   requester details and reports in desktop/mobile browsers.
7. Configure staging Firebase credentials/device tokens and queue/broadcast
   services. Send a controlled notification to a test recipient and check delivery.
8. Review reconstructed deadlines and reminder recipients, then enable
   `IT_TICKET_REMINDERS_ENABLED=true` in staging and run its scheduler.

## Still Required For Sign-Off

- Browser verification: the browser connector failed during runtime setup.
- Real Firebase/broadcast delivery and cron/queue operation.
- Restricted-role mapping, live-data migration and legacy public-file retirement. The three approved new grants are Super admin only on the independent test DB.
- Full CRUD and report/dashboard behavior coverage; fresh migrations and seeders pass on MySQL.
- Exact source PDF/layout comparison and upload reconciliation after a process
  crash or an outer transaction rollback.

The successful checks above are evidence for the tested scope, not a declaration
that both domains are production-ready.
