<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Mockery;
use Modules\Marketing\Reports\Queries\ReportData;
use Modules\Marketing\Reports\Services\MarketingReportService;
use Tests\TestCase;

class MarketingReportsTest extends TestCase
{
    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function test_report_preserves_summary_sections_and_date_order(): void
    {
        Carbon::setTestNow('2026-10-12 12:00:00');
        $staff = (object) ['id' => 1, 'full_name' => 'Owner'];
        $plans = collect([(object) ['status' => 'published', 'platform' => 'facebook',
            'publish_date' => '2026-10-11', 'created_at' => Carbon::parse('2026-10-10'), 'staff' => $staff]]);
        $complains = collect([(object) ['status' => 'solved', 'priority' => 'high', 'platform' => 'instagram',
            'date' => '2026-10-10', 'created_at' => Carbon::parse('2026-10-10'),
            'updated_at' => Carbon::parse('2026-10-10 03:00'), 'staff' => $staff, 'sales' => $staff]]);
        $leads = collect([(object) ['source' => 'facebook', 'assigned_to' => 1,
            'created_at' => Carbon::parse('2026-10-11')]]);
        $data = Mockery::mock(ReportData::class);
        $data->shouldReceive('getPlans')->once()->andReturn($plans);
        $data->shouldReceive('getComplains')->once()->andReturn($complains);
        $data->shouldReceive('getLeads')->once()->andReturn($leads);
        $this->app->instance(ReportData::class, $data);
        $filters = ['from' => '2026-10-12', 'to' => '2026-10-10'];
        DB::enableQueryLog();
        $report = app(MarketingReportService::class)->build($filters);
        $this->assertCount(0, DB::getQueryLog());
        DB::disableQueryLog();
        $this->assertSame('2026-10-10', $report['from']);
        $this->assertSame('2026-10-12', $report['to']);
        $this->assertCount(5, $report['summaryCards']);
        $this->assertSame('100%', $report['summaryCards'][1]['value']);
        $this->assertSame('3h', $report['summaryCards'][3]['value']);
        $this->assertSame(['overview', 'plans', 'complaints', 'leads', 'performance'], array_keys($report['sections']));
        $this->assertSame([0, 1, 0], $report['sections']['plans']['right']['chart']['series']);

    }

    public function test_empty_report_keeps_default_range_and_zero_metrics(): void
    {
        Carbon::setTestNow('2026-10-12 12:00:00');
        $report = app(MarketingReportService::class)->build();
        $this->assertSame('2026-09-13', $report['from']);
        $this->assertSame('2026-10-12', $report['to']);
        $this->assertSame('0%', $report['summaryCards'][1]['value']);
        $this->assertSame('N/A', $report['summaryCards'][3]['value']);
        $this->assertCount(30, $report['sections']['leads']['right']['chart']['series']);
    }
}
