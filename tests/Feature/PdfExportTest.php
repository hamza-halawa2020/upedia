<?php

namespace Tests\Feature;

use App\Actions\Exports\DownloadExport;
use App\Models\Vendor;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PdfExportTest extends TestCase
{
    public function test_shared_pdf_export_generates_pdf_with_escaped_cells(): void
    {
        Schema::create('it_vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Vendor::create(['name' => '<script>unsafe</script>']);
        $export = new class
        {
            public function query()
            {
                return Vendor::query();
            }

            public function map($vendor)
            {
                return [$vendor->name];
            }

            public function headings()
            {
                return ['Vendor'];
            }
        };
        $response = app(DownloadExport::class)->handle($export, 'vendors', 'pdf');
        $this->assertStringStartsWith('%PDF-', $response->getContent());
        $this->assertStringContainsString('vendors.pdf', $response->headers->get('Content-Disposition'));
    }
}
