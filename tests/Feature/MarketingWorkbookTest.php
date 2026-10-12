<?php

namespace Tests\Feature;

use App\Models\MarketingPlan;
use App\Models\Script;
use App\Models\Staff;
use App\Models\SmHumanDepartment;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Marketing\Plans\Exports\MarketingPlansExport;
use Modules\Marketing\Scripts\Exports\ScriptsExport;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Tests\TestCase;

class MarketingWorkbookTest extends TestCase
{
    public function test_plan_workbook_has_correct_columns_and_literal_user_text(): void
    {
        $plan = new MarketingPlan([
            'id' => 1, 'name' => '=1+1', 'platform' => 'facebook', 'subject' => 'launch',
            'publish_date' => '2026-10-20', 'status' => 'ready-to-publish',
        ]);
        $plan->setRelation('staff', new Staff(['first_name' => 'Test', 'last_name' => 'Creator']));
        $sheet = $this->sheet(new MarketingPlansExport(collect([$plan])));
        $this->assertSame('Created By', $sheet->getCell('E1')->getValue());
        $this->assertSame('=1+1', $sheet->getCell('B2')->getValue());
        $this->assertSame(DataType::TYPE_STRING, $sheet->getCell('B2')->getDataType());
        $this->assertSame('Test Creator', $sheet->getCell('E2')->getValue());
        $this->assertSame('2026-10-20', $sheet->getCell('F2')->getValue());
        $this->assertSame('Ready to publish', $sheet->getCell('G2')->getValue());
        $this->assertSame(2, $sheet->getHighestRow());
    }

    public function test_script_workbook_preserves_departments_and_creation_date(): void
    {
        $script = new Script([
            'title' => '=HYPERLINK("https://example.test","text")', 'category_name' => 'Sales',
            'visibility' => 'departments', 'status' => 'approved', 'created_at' => '2026-10-12 10:30:00',
        ]);
        $script->setRelation('departments', (new SmHumanDepartment)->newCollection([
            new SmHumanDepartment(['name' => 'Sales']), new SmHumanDepartment(['name' => 'IT']),
        ]));
        $sheet = $this->sheet(new ScriptsExport(collect([$script])));
        $this->assertSame('Title', $sheet->getCell('A1')->getValue());
        $this->assertSame(DataType::TYPE_STRING, $sheet->getCell('A2')->getDataType());
        $this->assertSame($script->title, $sheet->getCell('A2')->getValue());
        $this->assertSame('Sales, IT', $sheet->getCell('E2')->getValue());
        $this->assertSame('2026-10-12 10:30:00', $sheet->getCell('F2')->getValue());
    }

    private function sheet($export): \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
    {
        Storage::fake('local');
        Storage::disk('local')->put('export.xlsx', Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX));

        return IOFactory::load(Storage::disk('local')->path('export.xlsx'))->getActiveSheet();
    }
}
