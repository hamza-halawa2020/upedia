<?php

namespace Modules\IT\Tickets\Queries;

use App\Models\Staff;

class TicketStaff
{
    public function department(int $id)
    {
        return Staff::where('department_id', $id)->get(['id', 'first_name', 'last_name', 'department_id']);
    }

    public function search(string $search)
    {
        if (mb_strlen(trim($search)) < 2) {
            return collect();
        }

        return Staff::with('department:id,name')->where(function ($query) use ($search) {
            foreach (['full_name', 'first_name', 'last_name', 'email', 'staff_no'] as $field) {
                $query->orWhere($field, 'like', '%'.$search.'%');
            }
        })->orderBy('full_name')->limit(10)->get(['id', 'first_name', 'last_name', 'full_name', 'department_id'])
            ->map(fn ($staff) => ['id' => $staff->id, 'full_name' => $staff->full_name ?: trim($staff->first_name.' '.$staff->last_name),
                'department_name' => $staff->department?->name]);
    }

    public function details(int $id): array
    {
        $staff = Staff::with('department:id,name')->findOrFail($id);

        return ['id' => $staff->id, 'full_name' => $staff->full_name ?: trim($staff->first_name.' '.$staff->last_name),
            'department_name' => $staff->department?->name,
            'phone' => trim(($staff->mobile_dial_code ?? '').' '.($staff->mobile ?? $staff->home_phone ?? ''))];
    }
}
