<?php

namespace Modules\Marketing\Complaints\Queries;

use App\Models\Lead;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Collection;

class FindClientMatches
{
    public function handle(string $phoneNumber): Collection
    {
        $searchPart = $this->phoneSearchPart($phoneNumber);

        if ($searchPart === '') {
            return collect();
        }

        $leads = $this->leadRecords($searchPart);
        $students = $this->studentRecords($searchPart);
        $users = $this->userMatches($searchPart);
        $staffById = $this->staffById($leads, $students);

        return collect()
            ->merge($this->leadMatches($leads, $staffById))
            ->merge($users)
            ->merge($this->studentMatches($students, $staffById, $searchPart))
            ->unique(fn ($match) => $match['source'] . ':' . $match['id'] . ':' . $match['phone'])
            ->values()
            ->take(10);
    }

    private function leadRecords(string $searchPart): Collection
    {
        return Lead::query()
            ->where('phone', 'like', "%{$searchPart}%")
            ->limit(5)
            ->get(['id', 'first_name', 'last_name', 'phone', 'source', 'assigned_to']);
    }

    private function studentRecords(string $searchPart): Collection
    {
        return Student::query()
            ->where('mobile', 'like', "%{$searchPart}%")
            ->orWhere('another_mobile', 'like', "%{$searchPart}%")
            ->limit(5)
            ->get(['id', 'first_name', 'last_name', 'full_name', 'mobile', 'another_mobile', 'created_by']);
    }

    private function userMatches(string $searchPart): Collection
    {
        return User::query()
            ->where('phone_number', 'like', "%{$searchPart}%")
            ->with('staff:id,user_id,first_name,last_name,full_name')
            ->limit(5)
            ->get(['id', 'full_name', 'phone_number'])
            ->map(fn (User $user) => [
                'id' => $user->id,
                'source' => 'user',
                'source_label' => 'Retention',
                'department' => 'retention',
                'system' => 'Users',
                'platform' => null,
                'phone' => $user->phone_number,
                'client_name' => $user->full_name,
                'staff_id' => $user->staff?->id,
                'staff_name' => $this->staffName($user->staff),
            ]);
    }

    private function staffById(Collection $leads, Collection $students): Collection
    {
        $ids = $leads->pluck('assigned_to')
            ->merge($students->pluck('created_by'))
            ->filter()
            ->unique()
            ->values();

        return Staff::query()
            ->whereIn('id', $ids)
            ->orWhereIn('user_id', $ids)
            ->get(['id', 'user_id', 'first_name', 'last_name', 'full_name'])
            ->flatMap(fn (Staff $staff) => [
                'id:' . $staff->id => $staff,
                'user:' . $staff->user_id => $staff,
            ]);
    }

    private function leadMatches(Collection $leads, Collection $staffById): Collection
    {
        return $leads->map(function (Lead $lead) use ($staffById) {
            $staff = $staffById->get('id:' . $lead->assigned_to)
                ?? $staffById->get('user:' . $lead->assigned_to);

            return [
                'id' => $lead->id,
                'source' => 'lead',
                'source_label' => 'Sales',
                'department' => 'sales',
                'system' => 'CRM Leads',
                'platform' => $this->platformValue($lead->source),
                'phone' => $lead->phone,
                'client_name' => $this->personName($lead->first_name, $lead->last_name),
                'staff_id' => $staff?->id,
                'staff_name' => $this->staffName($staff),
            ];
        });
    }

    private function studentMatches(Collection $students, Collection $staffById, string $searchPart): Collection
    {
        return $students->map(function (Student $student) use ($staffById, $searchPart) {
            $staff = $staffById->get('id:' . $student->created_by)
                ?? $staffById->get('user:' . $student->created_by);

            return [
                'id' => $student->id,
                'source' => 'student',
                'source_label' => 'Retention',
                'department' => 'retention',
                'system' => 'Students',
                'platform' => null,
                'phone' => str_contains((string) $student->another_mobile, $searchPart)
                    ? $student->another_mobile
                    : $student->mobile,
                'client_name' => $this->personName($student->first_name, $student->last_name, $student->full_name),
                'staff_id' => $staff?->id,
                'staff_name' => $this->staffName($staff),
            ];
        });
    }

    private function phoneSearchPart(string $phoneNumber): string
    {
        $cleanNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        return strlen($cleanNumber) >= 9 ? substr($cleanNumber, -9) : $cleanNumber;
    }

    private function staffName(?Staff $staff): ?string
    {
        return $staff ? $this->personName($staff->first_name, $staff->last_name, $staff->full_name) : null;
    }

    private function personName(?string $firstName, ?string $lastName, ?string $fallback = null): ?string
    {
        $name = trim(($firstName ?? '') . ' ' . ($lastName ?? ''));

        return $name !== '' ? $name : $fallback;
    }

    private function platformValue(?string $source): ?string
    {
        $source = strtolower(trim((string) $source));

        return match ($source) {
            'facebook', 'tiktok', 'youtube', 'snapchat', 'instagram' => $source,
            'x' => 'X',
            default => null,
        };
    }
}
