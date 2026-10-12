<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Marketing\Plans\Queries\ListMarketingPlans;
use Tests\TestCase;

class MarketingPlanListingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->unsignedBigInteger('job_title_id')->nullable();
        });
        Schema::create('hr_job_titles', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
        });
        Schema::create('marketing_plans', function (Blueprint $table) {
            $table->id();
            foreach (['name', 'subject', 'description', 'platform', 'status', 'type', 'month'] as $column) {
                $table->string($column)->nullable();
            }
            $table->date('publish_date')->nullable();
            $table->unsignedBigInteger('created_by');
        });
    }

    public function test_content_creator_scope_applies_to_listing_and_export_collection(): void
    {
        $user = $this->creator();
        $this->plan(1, 101);
        $this->plan(2, 202);
        $query = app(ListMarketingPlans::class);

        $this->assertSame([1], $query->paginate([], $user)->getCollection()->modelKeys());
        $this->assertSame([1], $query->collection([], $user)->modelKeys());
        $this->assertCount(0, $query->collection(['created_by' => 202], $user));
        $this->assertSame(0, $query->paginate(['created_by' => 202], $user)->total());
    }

    public function test_search_and_date_aliases_match_for_list_and_export(): void
    {
        $user = $this->creator();
        $this->plan(1, 101);
        $this->plan(2, 101, ['platform' => 'youtube']);
        $this->plan(3, 101, ['publish_date' => '2026-11-01', 'month' => 'November']);
        $criteria = [
            'search' => 'description keyword', 'platform' => 'facebook', 'status' => 'draft',
            'type' => 'design', 'month' => 'October',
            'start_date' => '2026-10-01', 'end_date' => '2026-10-31',
        ];
        $query = app(ListMarketingPlans::class);
        $this->assertSame([1], $query->collection($criteria, $user)->modelKeys());
        $this->assertSame([1], $query->paginate($criteria, $user)->getCollection()->modelKeys());
        $this->assertSame([3], $query->collection(['from' => '2026-11-01'], $user)->modelKeys());
        $this->assertCount(2, $query->collection(['to' => '2026-10-31'], $user));
    }

    public function test_pagination_preserves_filters_and_eager_loads_staff(): void
    {
        $user = $this->creator();
        for ($id = 1; $id <= 6; $id++) {
            $this->plan($id, 101);
        }
        $this->app->instance('request', Request::create('/marketing/plans', 'GET', [
            'platform' => 'facebook', 'month' => 'October', 'per_page' => 5,
        ]));
        $page = app(ListMarketingPlans::class)->paginate(['platform' => 'facebook', 'per_page' => 5], $user);
        parse_str(parse_url($page->nextPageUrl(), PHP_URL_QUERY), $parameters);
        $this->assertSame('facebook', $parameters['platform']);
        $this->assertSame('October', $parameters['month']);
        $this->assertSame('2', $parameters['page']);
        $this->assertCount(5, $page->items());
        DB::enableQueryLog();
        DB::flushQueryLog();
        foreach ($page->items() as $plan) {
            $this->assertTrue($plan->relationLoaded('staff'));
            $this->assertSame('Creator', $plan->staff->first_name);
        }
        $this->assertSame([], DB::getQueryLog());
        DB::disableQueryLog();
    }

    private function creator(): User
    {
        $user = User::create([
            'full_name' => 'Creator', 'email' => 'listing@example.test',
            'password' => bcrypt('test-password'),
        ]);
        DB::table('hr_job_titles')->insert(['id' => 1, 'slug' => 'content-creator']);
        DB::table('sm_staffs')->insert([
            'id' => 101, 'full_name' => 'Creator', 'first_name' => 'Creator', 'last_name' => 'Test',
            'email' => 'creator@example.test', 'user_id' => $user->id, 'job_title_id' => 1,
        ]);

        return $user;
    }

    private function plan(int $id, int $owner, array $overrides = []): void
    {
        DB::table('marketing_plans')->insert(array_replace([
            'id' => $id, 'created_by' => $owner, 'name' => 'Plan '.$id, 'subject' => 'Subject',
            'description' => 'description keyword', 'platform' => 'facebook', 'status' => 'draft',
            'type' => 'design', 'month' => 'October', 'publish_date' => '2026-10-20',
        ], $overrides));
    }
}
