<?php

namespace Database\Seeders;

use App\Models\SmHumanDepartment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class RequestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $requestTypes = [
            ['id' => 1, 'name' => 'complaint', 'priority' => 'high', 'department_name' => 'Support'],
            ['id' => 2, 'name' => 'request', 'priority' => 'medium', 'department_name' => 'Operations'],
            ['id' => 3, 'name' => 'information', 'priority' => 'low', 'department_slug' => 'academy'],
            ['id' => 4, 'name' => 'need', 'priority' => 'medium', 'department_slug' => 'academy'],
            ['id' => 5, 'name' => 'escalation', 'priority' => 'high', 'department_name' => 'Quality EDITED'],
            ['id' => 6, 'name' => 'refund', 'priority' => 'high', 'department_name' => 'Operations'],
            ['id' => 7, 'name' => 'New', 'priority' => 'high', 'department_slug' => 'hr'],
        ];

        foreach ($requestTypes as $requestType) {
            DB::table('request_types')->updateOrInsert(
                ['id' => $requestType['id']],
                [
                    'name' => $requestType['name'],
                    'priority_id' => $this->priorityId($requestType['priority']),
                    'target_department_id' => $this->departmentId($requestType),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );
        }
    }

    private function priorityId(string $name): int
    {
        $id = DB::table('request_priorities')
            ->where('name', $name)
            ->value('id');

        if ($id === null) {
            throw new RuntimeException("Request priority [{$name}] was not found.");
        }

        return (int) $id;
    }

    /**
     * @param array<string, mixed> $requestType
     */
    private function departmentId(array $requestType): int
    {
        if (isset($requestType['department_slug'])) {
            return SmHumanDepartment::where('slug', $requestType['department_slug'])
                ->firstOrFail()
                ->id;
        }

        return SmHumanDepartment::where('name', $requestType['department_name'])
            ->firstOrFail()
            ->id;
    }
}
