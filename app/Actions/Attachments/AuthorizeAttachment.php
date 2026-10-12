<?php

namespace App\Actions\Attachments;

use App\Models\Attachment;
use App\Models\User;
use App\Models\Script;
use App\Models\ItSolution;
use Modules\Marketing\Scripts\Actions\AuthorizeScriptAccess;
use Modules\IT\Solutions\Queries\VisibleSolutions;

class AuthorizeAttachment
{
    public function handle(User $user, Attachment $attachment, bool $delete = false): void
    {
        $permissions = [
            \App\Models\MarketingPlan::class => ['marketing_plans_show', 'marketing_plans_edit'],
            \App\Models\Complain::class => ['marketing_complains_show', 'marketing_complains_edit'],
            \App\Models\Ticket::class => ['it_tickets_show', 'it_tickets_edit'],
            \App\Models\Purchase::class => ['it_purchase_show', 'it_purchase_edit'],
            ItSolution::class => ['it_solutions_show', 'it_solutions_edit'],
        ];
        $class = $attachment->model_type;
        abort_unless($class === Script::class || isset($permissions[$class]), 404);
        $owner = $attachment->attachable;
        abort_unless($owner, 404);
        if ($class === Script::class) {
            $owner->load('departments');
            app(AuthorizeScriptAccess::class)->handle($user, $owner, $delete ? 'edit' : 'view');
            return;
        }
        if ($class === ItSolution::class && !$delete && !$user->can('it_solutions_show')) {
            app(VisibleSolutions::class)->find($user, $owner->id);
            return;
        }
        abort_unless($user->can($permissions[$class][$delete ? 1 : 0]), 403);
        if ($delete && $class === \App\Models\Purchase::class) { abort_unless($owner->status === 'pending', 409); }
    }
}
