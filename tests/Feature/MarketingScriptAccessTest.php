<?php

namespace Tests\Feature;

use App\Models\Script;
use App\Models\SmHumanDepartment;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Marketing\Scripts\Actions\AuthorizeScriptAccess;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class MarketingScriptAccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->unsignedBigInteger('job_title_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
        });
        Schema::create('hr_job_titles', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
        });
    }

    public function test_owner_can_view_and_edit_their_script(): void
    {
        $user = $this->user();
        $script = $this->script($user->id, 'draft');
        app(AuthorizeScriptAccess::class)->handle($user, $script, 'view');
        app(AuthorizeScriptAccess::class)->handle($user, $script, 'edit');
        $this->assertTrue(true);
    }

    public function test_marketing_manager_can_edit_another_users_script(): void
    {
        $user = $this->user('marketing_manager');
        app(AuthorizeScriptAccess::class)->handle($user, $this->script(999, 'draft'), 'edit');
        $this->assertTrue(true);
    }

    public function test_department_member_can_only_view_an_approved_script(): void
    {
        $user = $this->user('content-creator', 24);
        $script = $this->script(999, 'approved', 24);
        app(AuthorizeScriptAccess::class)->handle($user, $script, 'view');
        $this->assertTrue(true);
        $this->assertDenied($user, $script, 'edit');
        $this->assertDenied($user, $script, 'delete');
    }

    public function test_unapproved_and_other_department_scripts_are_hidden(): void
    {
        $user = $this->user('content-creator', 24);
        $this->assertDenied($user, $this->script(999, 'draft', 24), 'view');
        $this->assertDenied($user, $this->script(999, 'approved', 31), 'view');
    }

    public function test_user_without_staff_cannot_view_another_users_script(): void
    {
        $user = $this->user();
        $this->assertDenied($user, $this->script(999, 'approved', 24), 'view');
    }

    public function test_super_admin_can_access_without_staff(): void
    {
        $user = $this->actingAsAdminWithPermissions();
        app(AuthorizeScriptAccess::class)->handle($user, $this->script(999, 'draft'), 'edit');
        $this->assertTrue(true);
    }

    private function user(?string $slug = null, int $department = 24): User
    {
        $user = User::create([
            'full_name' => 'Test user', 'email' => 'script@example.test',
            'password' => bcrypt('test-password'),
        ]);
        if ($slug !== null) {
            DB::table('hr_job_titles')->insert(['id' => 1, 'slug' => $slug]);
            DB::table('sm_staffs')->insert([
                'full_name' => 'Test user', 'first_name' => 'Test', 'last_name' => 'User',
                'email' => 'staff@example.test', 'user_id' => $user->id,
                'job_title_id' => 1, 'department_id' => $department,
            ]);
        }

        return $user;
    }

    private function script(int $owner, string $status, ?int $department = null): Script
    {
        $script = new Script(['created_by' => $owner, 'status' => $status]);
        $departments = $department === null ? [] : [new SmHumanDepartment(['id' => $department])];
        $script->setRelation('departments', (new SmHumanDepartment)->newCollection($departments));

        return $script;
    }

    private function assertDenied(User $user, Script $script, string $action): void
    {
        try {
            app(AuthorizeScriptAccess::class)->handle($user, $script, $action);
            $this->fail('Unauthorized script access was permitted.');
        } catch (HttpException $exception) {
            $this->assertSame(403, $exception->getStatusCode());
        }
    }
}
