<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Modules\IT\SavedTables\Queries\PreviewSavedTable;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

class SavedPreviewTest extends TestCase
{
    public function test_preview_limits_rows_and_does_not_evaluate_formulas(): void
    {
        Storage::fake('local');
        $book = new Spreadsheet;
        $sheet = $book->getActiveSheet();
        $sheet->setCellValue('A1', 'Value');
        $sheet->setCellValue('A2', '=1+1');
        for ($i = 3; $i <= 250; $i++) {
            $sheet->setCellValue('A'.$i, $i);
        }
        $path = Storage::disk('local')->path('preview.xlsx');
        (new Xlsx($book))->save($path);
        $book->disconnectWorksheets();
        $data = app(PreviewSavedTable::class)->handle($path);
        $this->assertSame(['Value'], $data['headers']);
        $this->assertCount(200, $data['rows']);
        $this->assertSame('=1+1', $data['rows'][0][0]);
    }

    public function test_csv_cells_stay_plain_text(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('preview.csv', "Name,Value\n<script>text</script>,42\n");
        $data = app(PreviewSavedTable::class)->handle(Storage::disk('local')->path('preview.csv'));
        $this->assertSame(['Name', 'Value'], $data['headers']);
        $this->assertSame('<script>text</script>', $data['rows'][0][0]);
    }
}
