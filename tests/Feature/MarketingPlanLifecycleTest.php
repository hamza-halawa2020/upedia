<?php

namespace Tests\Feature;

use App\Http\Middleware\SsoTokenAuthenticate;
use App\Models\User;
use App\Services\Notifications\MarketingNotificationService;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Modules\Marketing\Plans\Actions\CreateMarketingPlan;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class MarketingPlanLifecycleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        Schema::create('marketing_plans', function (Blueprint $table) {
            $table->id();
            foreach (['name', 'subject', 'month', 'platform', 'status', 'type', 'publish_time', 'description', 'comments'] as $column) {
                $table->string($column)->nullable();
            }
            $table->date('publish_date')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
        Schema::create('hr_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('model_id');
            foreach (['model_type', 'file_path', 'original_name', 'file_type'] as $column) {
                $table->string($column);
            }
            $table->timestamps();
        });
        $this->withoutMiddleware(SsoTokenAuthenticate::class);
        $user = User::create(['full_name' => 'Planner', 'email' => 'planner@example.test', 'password' => bcrypt('test')]);
        DB::table('sm_staffs')->insert([
            'id' => 101, 'user_id' => $user->id, 'full_name' => 'Planner', 'first_name' => 'Planner',
            'last_name' => 'Test', 'email' => 'planner-staff@example.test',
        ]);
        foreach (['create', 'edit', 'destroy'] as $action) {
            Permission::create(['name' => 'marketing_plans_'.$action, 'guard_name' => 'web']);
        }
        $user->givePermissionTo(['marketing_plans_create', 'marketing_plans_edit', 'marketing_plans_destroy']);
        $this->actingAs($user);
    }

    public function test_http_lifecycle_persists_staff_ownership_and_updates_then_deletes(): void
    {
        $service = $this->mock(MarketingNotificationService::class);
        $service->shouldReceive('planChanged')->times(3);
        $this->post('/marketing/plans', $this->data())->assertRedirect();
        $id = DB::table('marketing_plans')->value('id');
        $this->assertNotNull($id);
        $this->assertDatabaseHas('marketing_plans', ['id' => $id, 'created_by' => 101]);
        $this->put('/marketing/plans/'.$id, $this->data(['name' => 'Updated']))->assertRedirect();
        $this->assertDatabaseHas('marketing_plans', ['id' => $id, 'name' => 'Updated']);
        $this->delete('/marketing/plans/'.$id)->assertRedirect();
        $this->assertDatabaseCount('marketing_plans', 0);
    }

    public function test_attachment_failure_rolls_back_plan_and_suppresses_created_notification(): void
    {
        $this->mock(MarketingNotificationService::class)->shouldNotReceive('planChanged');
        DB::statement("CREATE TRIGGER block_plan_file BEFORE INSERT ON hr_attachments BEGIN SELECT RAISE(ABORT, 'blocked'); END");
        try {
            app(CreateMarketingPlan::class)->handle($this->data(), [UploadedFile::fake()->image('plan.png')]);
            $this->fail('Expected attachment write failure.');
        } catch (QueryException) {
            $this->assertDatabaseCount('marketing_plans', 0);
            $this->assertDatabaseCount('hr_attachments', 0);
            $this->assertSame([], Storage::disk('local')->allFiles('private-attachments/marketing-plans'));
        }
    }

    public function test_invalid_dates_and_platforms_do_not_create_a_plan(): void
    {
        $this->mock(MarketingNotificationService::class)->shouldNotReceive('planChanged');
        $this->postJson('/marketing/plans', $this->data(['publish_date' => now()->subDay()->toDateString(), 'platform' => 'invalid']))
            ->assertUnprocessable()->assertJsonValidationErrors(['publish_date', 'platform']);
        $this->assertDatabaseCount('marketing_plans', 0);
    }

    private function data(array $overrides = []): array
    {
        return array_replace(['name' => 'Plan', 'subject' => 'Subject', 'platform' => 'facebook', 'type' => 'design', 'status' => 'draft'], $overrides);
    }
}
