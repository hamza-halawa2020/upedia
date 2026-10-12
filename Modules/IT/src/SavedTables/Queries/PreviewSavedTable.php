<?php

namespace Modules\IT\SavedTables\Queries;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class PreviewSavedTable
{
    public function handle(string $path): array
    {
        abort_if(filesize($path) > 10 * 1024 * 1024, 413, 'Download this file to view it.');
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        abort_unless(in_array($extension, ['xlsx', 'xls', 'csv'], true), 415);
        if ($extension === 'xlsx') {
            $zip = new \ZipArchive;
            abort_unless($zip->open($path) === true, 422);
            $size = 0;
            try {
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $size += $zip->statIndex($i)['size'];
                    abort_if($size > 50 * 1024 * 1024, 413, 'Workbook is too large to preview.');
                }
            } finally {
                $zip->close();
            }
        }
        $reader = IOFactory::createReader(match ($extension) {
            'xlsx' => 'Xlsx', 'xls' => 'Xls', default => 'Csv'
        });
        $reader->setReadDataOnly(true);
        $reader->setReadFilter(new class implements IReadFilter
        {
            public function readCell($columnAddress, $row, $worksheetName = '')
            {
                return $row <= 201 && Coordinate::columnIndexFromString($columnAddress) <= 50;
            }
        });
        if ($extension !== 'csv') {
            $names = $reader->listWorksheetNames($path);
            if ($names) {
                $reader->setLoadSheetsOnly($names[0]);
            }
        }
        $book = $reader->load($path);
        try {
            $sheet = $book->getActiveSheet();
            $lastColumn = min(50, Coordinate::columnIndexFromString($sheet->getHighestDataColumn()));
            $lastRow = min(201, $sheet->getHighestDataRow());
            // Never evaluate formulas while previewing stored spreadsheets.
            $rows = $sheet->rangeToArray('A1:'.Coordinate::stringFromColumnIndex($lastColumn).$lastRow, null, false, false);

            return ['headers' => array_shift($rows) ?? [], 'rows' => $rows];
        } finally {
            $book->disconnectWorksheets();
        }
    }
}
