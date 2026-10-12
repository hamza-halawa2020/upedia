<?php

namespace Tests\Feature;

use App\Models\ItSolution;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\IT\Solutions\Queries\VisibleSolutions;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class SolutionsVisibilityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        Schema::create('it_solutions', function (Blueprint $table) {
            $table->id(); $table->string('title'); $table->string('topic_name');
            $table->text('description'); $table->string('keywords')->nullable();
            $table->string('visibility'); $table->integer('views_count')->default(0); $table->timestamps();
        });
        Schema::create('it_solution_sm_human_department', function (Blueprint $table) {
            $table->unsignedBigInteger('it_solution_id'); $table->unsignedBigInteger('sm_human_department_id');
        });
        Schema::create('hr_attachments', function (Blueprint $table) {
            $table->id(); $table->string('model_type'); $table->unsignedBigInteger('model_id'); $table->string('file_path');
        });
    }

    public function test_non_it_user_cannot_find_private_solution(): void
    {
        $user = $this->actingAsAdminWithPermissions();
        Permission::create(['name' => 'it_solutions_create', 'guard_name' => 'web']);
        $public = $this->solution('all');
        $private = $this->solution('it_only');
        $query = app(VisibleSolutions::class);
        $this->assertSame([$public->id], $query->list($user, [])->pluck('id')->all());
        $this->expectException(ModelNotFoundException::class);
        $query->find($user, $private->id);
    }

    public function test_it_permission_allows_private_but_not_unrelated_department_solution(): void
    {
        $user = $this->actingAsAdminWithPermissions();
        $user->givePermissionTo(Permission::create(['name' => 'it_solutions_create', 'guard_name' => 'web']));
        $private = $this->solution('it_only');
        $this->solution('departments');
        $query = app(VisibleSolutions::class);
        $this->assertSame($private->id, $query->find($user, $private->id)->id);
        $this->assertSame(1, $query->list($user, ['search' => 'Guide', 'sort' => 'az'])->total());
    }

    private function solution(string $visibility): ItSolution
    {
        return ItSolution::create(['title' => 'Guide', 'topic_name' => 'Topic', 'description' => 'Description', 'visibility' => $visibility]);
    }

    public function test_administration_creates_updates_and_detaches_departments(): void
    {
        $user = $this->actingAsAdminWithPermissions();
        foreach (['create', 'edit', 'destroy'] as $action) {
            $user->givePermissionTo(Permission::create(['name' => 'it_solutions_'.$action, 'guard_name' => 'web']));
        }
        $department = \App\Models\SmHumanDepartment::create(['name' => 'IT']);
        $data = ['title' => 'Guide', 'topic_name' => 'Topic', 'description' => 'Content',
            'visibility' => 'departments', 'department_ids' => [$department->id]];
        $this->actingAs($user)->post('/it/it-solutions', $data)->assertRedirect(route('it.it-solutions.index'));
        $solution = ItSolution::sole();
        $this->assertSame([$department->id], $solution->departments->pluck('id')->all());
        $data['visibility'] = 'all';
        $this->put('/it/it-solutions/'.$solution->id, $data)->assertRedirect();
        $this->assertCount(0, $solution->fresh()->departments);
        $this->delete('/it/it-solutions/'.$solution->id)->assertRedirect();
        $this->assertDatabaseCount('it_solutions', 0);
    }

    public function test_administration_requires_permission_and_department_selection(): void
    {
        $user = $this->actingAsAdminWithPermissions();
        $permission = Permission::create(['name' => 'it_solutions_create', 'guard_name' => 'web']);
        $data = ['title' => 'Guide', 'topic_name' => 'Topic', 'description' => 'Content', 'visibility' => 'departments'];
        $this->actingAs($user)->post('/it/it-solutions', $data)->assertForbidden();
        $user->givePermissionTo($permission);
        $this->post('/it/it-solutions', $data)->assertSessionHasErrors('department_ids');
        $this->assertDatabaseCount('it_solutions', 0);
    }

    public function test_delete_preserves_existing_attachment_and_solution(): void
    {
        $user = $this->actingAsAdminWithPermissions();
        $user->givePermissionTo(Permission::create(['name' => 'it_solutions_destroy', 'guard_name' => 'web']));
        $solution = $this->solution('all');
        \Illuminate\Support\Facades\DB::table('hr_attachments')->insert([
            'model_type' => ItSolution::class, 'model_id' => $solution->id, 'file_path' => 'uploads/solutions/file.pdf',
        ]);
        $this->actingAs($user)->delete('/it/it-solutions/'.$solution->id)->assertSessionHasErrors('solution');
        $this->assertDatabaseCount('it_solutions', 1);
        $this->assertDatabaseCount('hr_attachments', 1);
    }
}
