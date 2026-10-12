<?php

namespace App\Console\Commands;

use App\Queries\Readiness\RequiredModulePermissions;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AuditModulePermissionsCommand extends Command
{
    protected $signature = 'migration:audit-permissions';
    protected $description = 'Read-only audit of Marketing, IT and Firebase configuration permissions';

    public function handle(RequiredModulePermissions $required): int
    {
        $names = $required->handle();
        $existing = DB::table('permissions')->where('guard_name', 'web')->whereIn('name', $names)->get()->keyBy('name');
        $assigned = DB::table('role_has_permissions')->whereIn('permission_id', $existing->pluck('id'))
            ->select('permission_id')->selectRaw('COUNT(DISTINCT role_id) as total')->groupBy('permission_id')->get()->keyBy('permission_id');
        $rows = [];
        $missing = 0;
        $unassigned = 0;
        foreach ($names as $name) {
            $permission = $existing->get($name);
            $roles = $permission ? (int) ($assigned->get($permission->id)?->total ?? 0) : 0;
            $missing += $permission ? 0 : 1;
            $unassigned += $permission && ! $roles ? 1 : 0;
            $rows[] = [$name, $permission ? 'present' : 'missing', $roles];
        }
        $this->table(['Permission', 'Status', 'Assigned Roles'], $rows);
        $this->info("Missing: {$missing}; present without role assignment: {$unassigned}.");
        $this->warn('No roles or permissions were changed. Direct user grants are not included in role counts.');

        return $missing || $unassigned ? self::FAILURE : self::SUCCESS;
    }
}
