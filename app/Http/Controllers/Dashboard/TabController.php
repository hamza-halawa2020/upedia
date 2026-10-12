<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SmHumanDepartment;
use App\Models\Staff;
use App\Models\Tab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TabController extends \Illuminate\Routing\Controller
{

    public function __construct()
    {
        $this->middleware('check.permission:general_tabs_index')->only(['index', 'exportTemplate', 'export']);
        $this->middleware('check.permission:general_tabs_update')->only(['edit', 'update', 'import']);
    }

    public function export(Request $request)
    {
        $query = Tab::query();

        // Apply filters (Same as index)
        if ($search = $request->query('search')) {
            $query->where('label', 'like', "%{$search}%");
        }

        if ($request->filled('parent_id')) {
            $query->where('parent_id', $request->parent_id);
        }

        if ($request->filled('system')) {
            $query->whereJsonContains('systems', $request->system);
        }

        if ($request->filled('type')) {
            if ($request->type === 'link') {
                $query->whereNotNull('url');
            } elseif ($request->type === 'group') {
                $query->whereNull('url');
            }
        }

        $tabs = $query->orderBy('id', 'asc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=tabs_export_" . date('Y-m-d') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['id', 'label', 'url', 'icon', 'parent_label', 'systems', 'order'];

        $callback = function () use ($tabs, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            fputcsv($file, $columns);

            foreach ($tabs as $tab) {
                fputcsv($file, [
                    $tab->id,
                    $tab->label,
                    $tab->url ?? '',
                    $tab->icon ?? '',
                    $tab->parent->label ?? '',
                    $tab->systems ? implode(',', $tab->systems) : '',
                    $tab->order ?? 0,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportTemplate()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=tabs_template.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['label', 'url', 'icon', 'parent_label', 'systems', 'order'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            fputcsv($file, $columns);
            
            // Add a sample row
            fputcsv($file, ['HR Dashboard', '/dashboard/hr', 'ion:people', 'Human Resources', 'hr,settings', '1']);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        ini_set('max_execution_time', 300);
        ini_set('auto_detect_line_endings', true);

        $file = $request->file('file');
        $path = $file->getRealPath();
        
        $rawLineCount = count(file($path));

        $handle = fopen($path, 'r');
        
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            return redirect()->back()->with('error', 'The file is empty or invalid.');
        }
        $header = array_map('trim', $header);

        $countBefore = Tab::count();
        $importedCount = 0;
        $updatedCount = 0;
        $duplicateInFileCount = 0;
        $skippedEmptyCount = 0;
        $columnMismatchCount = 0;
        $errors = [];
        $processedInThisFile = []; 

        $index = 0;

        \DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle)) !== false) {
                $index++;
                $rowNumber = $index + 1;
                
                if (empty(array_filter($row, fn($val) => !is_null($val) && trim($val) !== ''))) {
                    $skippedEmptyCount++;
                    continue;
                }

                if (count($header) !== count($row)) {
                    $columnMismatchCount++;
                    $errors[] = "Row {$rowNumber}: Column mismatch.";
                    continue;
                }

                $item = array_combine($header, $row);
                $label = trim($item['label'] ?? '');
                $parentLabel = trim($item['parent_label'] ?? '');

                if (empty($label)) continue;

                $uniqueKey = $label . '|' . $parentLabel;
                if (isset($processedInThisFile[$uniqueKey])) {
                    $duplicateInFileCount++;
                }
                $processedInThisFile[$uniqueKey] = true;
                
                try {
                    $parentId = null;
                    if (!empty($parentLabel)) {
                        $parent = Tab::firstOrCreate(
                            ['label' => $parentLabel, 'url' => null],
                            ['icon' => 'lucide:folder', 'order' => 0]
                        );
                        $parentId = $parent->id;
                    }

                    $systems = !empty($item['systems']) 
                        ? array_map('trim', explode(',', $item['systems'])) 
                        : null;

                    $tab = Tab::where('label', $label)->where('parent_id', $parentId)->first();
                    
                    if ($tab) {
                        $tab->update([
                            'url' => (!empty($item['url'])) ? $item['url'] : null,
                            'icon' => (!empty($item['icon'])) ? $item['icon'] : ($tab->icon ?: 'lucide:link'),
                            'order' => isset($item['order']) ? (int)$item['order'] : $tab->order,
                            'systems' => $systems,
                        ]);
                        $updatedCount++;
                    } else {
                        Tab::create([
                            'label' => $label,
                            'parent_id' => $parentId,
                            'url' => (!empty($item['url'])) ? $item['url'] : null,
                            'icon' => (!empty($item['icon'])) ? $item['icon'] : 'lucide:link',
                            'order' => (int)($item['order'] ?? 0),
                            'systems' => $systems,
                        ]);
                        $importedCount++;
                    }
                } catch (\Exception $e) {
                    $errors[] = "Row {$rowNumber} ({$label}): " . $e->getMessage();
                }
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            fclose($handle);
            return redirect()->back()->with('error', 'Fatal error: ' . $e->getMessage());
        }

        fclose($handle);

        $countAfter = Tab::count();
        $newRecords = $countAfter - $countBefore;

        $summary = "Import Complete: Subscribed records updated (+{$newRecords} net new). " . "The file contained " . ($index) . " records. " . "Final database count: {$countAfter}.";
        
        
        if (count($errors) > 0) {
            return redirect()->route('tabs.index')->with('success', $summary)->with('warning', "Errors encountered. Check logs.");
        }

        return redirect()->route('tabs.index')->with('success', $summary);
    }

    public function index(Request $request)
    {
        $query = Tab::query();

        if ($search = $request->query('search')) {
            $query->where('label', 'like', "%{$search}%");
        }

        // Filter by Parent Tab
        if ($request->filled('parent_id')) {
            $query->where('parent_id', $request->parent_id);
        }

        // Filter by System
        if ($request->filled('system')) {
            $query->whereJsonContains('systems', $request->system);
        }

        // Filter by Type (Link vs Group)
        if ($request->filled('type')) {
            if ($request->type === 'link') {
                $query->whereNotNull('url');
            } elseif ($request->type === 'group') {
                $query->whereNull('url');
            }
        }

        $perPage = $request->query('per_page', 10);
        $tabs = $query->orderBy('order', 'asc')->paginate($perPage)->appends($request->query());

        // Data for filters
        $parentTabs = Tab::whereNull('parent_id')->whereNull('url')->orderBy('label')->get();
        
        // Extract unique systems for filtering
        $allSystems = Tab::whereNotNull('systems')->pluck('systems')->flatten()->unique()->sort()->values();

        return view('dashboard.tabs.index', compact('tabs', 'parentTabs', 'allSystems'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'systems' => 'nullable|array',
        ]);

        Tab::create($validated);

        return redirect()->route('tabs.index')
            ->with('success', 'Tab created successfully!');

    }

    public function update(Request $request, $id)
    {
        $tab = Tab::findOrFail($id);

        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:tabs,id',
            'order' => 'nullable|integer',
            'systems' => 'nullable|array',
        ]);

        $tab->update($validated);

        return redirect()->route('tabs.index')
            ->with('success', 'Tab updated successfully!');
    }
    
}
