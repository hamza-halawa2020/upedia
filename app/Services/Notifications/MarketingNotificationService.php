<?php

namespace App\Services\Notifications;

use App\Models\Attachment;
use App\Models\Complain;
use App\Models\MarketingPlan;
use App\Models\QuickLink;
use App\Models\Script;
use App\Models\Staff;
use App\Models\User;
use App\Notifications\BaseNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MarketingNotificationService
{
    public function planChanged(MarketingPlan $plan, string $event): void
    {
        $plan->load('staff');

        $this->notifyUsers(
            $this->staffAndActorUsers($plan->staff),
            'Marketing plan '.$this->modelName($plan).' has been '.$event.'.',
            'Marketing Plan '.ucfirst($event),
            ['plans.show', $plan->id]
        );
    }

    public function scriptChanged(Script $script, string $event): void
    {
        $script->load('creator', 'approver');

        $users = collect([$script->creator, $script->approver, auth()->user()]);

        $this->notifyUsers(
            $users,
            'Script '.$this->modelName($script).' has been '.$event.'.',
            'Script '.ucfirst($event),
            ['scripts.show', $script->id]
        );
    }

    public function complainChanged(Complain $complain, string $event): void
    {
        $complain->load('staff', 'sales', 'solver');

        $users = collect([
            $this->staffUser($complain->staff),
            $this->staffUser($complain->sales),
            $complain->solver,
            auth()->user(),
        ]);

        $this->notifyUsers(
            $users,
            'Complain '.$this->modelName($complain).' has been '.$event.'.',
            'Complain '.ucfirst($event),
            ['complains.show', $complain->id]
        );
    }

    public function quickLinkChanged(QuickLink $quickLink, string $event): void
    {
        $quickLink->load('createdBy');

        $this->notifyUsers(
            collect([$quickLink->createdBy, auth()->user()]),
            'Quick link '.$this->modelName($quickLink).' has been '.$event.'.',
            'Quick Link '.ucfirst($event),
            ['quick_links.index']
        );
    }

    public function attachmentChanged(Attachment $attachment, string $event): void
    {
        $this->notifyActor(
            'Attachment '.$this->modelName($attachment).' has been '.$event.'.',
            'Attachment '.ucfirst($event),
            ['dashboard']
        );
    }

    public function genericChanged(Model $model, string $event, ?array $url = null): void
    {
        $this->notifyActor(
            class_basename($model).' '.$this->modelName($model).' has been '.$event.'.',
            class_basename($model).' '.ucfirst($event),
            $url ?? ['dashboard']
        );
    }

    private function staffAndActorUsers(?Staff $staff): Collection
    {
        return collect([$this->staffUser($staff), auth()->user()]);
    }

    private function staffUser(?Staff $staff): ?User
    {
        return $staff?->user_id ? User::query()->find($staff->user_id) : null;
    }

    private function notifyActor(string $message, string $title, array $url): void
    {
        $this->notifyUsers(collect([auth()->user()]), $message, $title, $url);
    }

    private function notifyUsers(Collection $users, string $message, string $title, array $url): void
    {
        $authId = auth()->id();

        $users
            ->filter()
            ->unique('id')
            ->reject(fn (User $user) => $authId && $user->id === $authId)
            ->each(fn (User $user) => $user->notify(new BaseNotification($message, $title, ['database'], $url)));
    }

    private function modelName(Model $model): string
    {
        foreach (['name', 'title', 'subject', 'client_name', 'original_name'] as $field) {
            if (! empty($model->{$field})) {
                return '"'.$model->{$field}.'"';
            }
        }

        return '#'.$model->getKey();
    }
}