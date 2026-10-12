<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Tab;
use Illuminate\Http\UploadedFile;

class TabTest extends TestCase
{

    public function testIndex(): void
    {
        $user = $this->actingAsAdminWithPermissions();
             
        $response = $this->actingAs($user)->get(route('tabs.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.tabs.index');
    }

    public function testStore(): void
    {
        $user = $this->actingAsAdminWithPermissions();

        $response = $this->actingAs($user)->post(route('tabs.store'), [
            'label' => 'test-label',
            'icon' => 'test-icon',
            'order' => 1,
            'systems' => ['test-systems'],
        ]);
        $response->assertRedirect(route('tabs.index'));
        
    }

    public function testUpdate(): void
    {
        $user = $this->actingAsAdminWithPermissions();

        $tab = Tab::create([
            'label' => 'test-label',
            'icon' => 'test-icon',
            'order' => 1,
            'systems' => ['test-systems'],
        ]);

        $response = $this->actingAs($user)->put(route('tabs.update', $tab->id), [
            'label' => 'test-label-updated',
            'icon' => 'test-icon-updated',
            'order' => 2,
            'systems' => ['test-systems-updated'],
        ]);
        $response->assertRedirect(route('tabs.index'));
    }

    public function testExportTemplate(): void
    {
        $user = $this->actingAsAdminWithPermissions();

        $response = $this->actingAs($user)->get(route('tabs.template'));

        $response->assertStatus(200);
    }

    public function testExport(): void
    {
        $user = $this->actingAsAdminWithPermissions();

        $response = $this->actingAs($user)->get(route('tabs.export'));
        $response->assertStatus(200);
    }

    public function testImport(): void
    {
        $user = $this->actingAsAdminWithPermissions();

        $response = $this->actingAs($user)->post(route('tabs.import'), [
            'file' => UploadedFile::fake()->create('tabs.csv', 100),
        ]);

        $response->assertRedirect('/');

    }
    
    public function testTabFilters(): void
    {
        $user = $this->actingAsAdminWithPermissions();

        $parentTab = Tab::create([
            'label' => 'Parent Tab',
            'order' => 1,
            'systems' => ['hr'],
        ]);

        $childTab = Tab::create([
            'label' => 'Child Tab',
            'parent_id' => $parentTab->id,
            'order' => 2,
            'systems' => ['hr'],
            'url' => '/child',
        ]);

        $otherTab = Tab::create([
            'label' => 'Other Tab',
            'order' => 3,
            'systems' => ['crm'],
            'url' => '/other',
        ]);

        $response = $this->actingAs($user)->get(route('tabs.index', [
            'parent_id' => $parentTab->id
        ]));

        $response->assertStatus(200);

        $labels = $response->viewData('tabs')->pluck('label')->toArray();

        $this->assertContains('Child Tab', $labels);
        $this->assertNotContains('Parent Tab', $labels);
        $this->assertNotContains('Other Tab', $labels);

        $response = $this->actingAs($user)->get(route('tabs.index', [
            'system' => 'hr'
        ]));
        $response->assertStatus(200);
        $labels = $response->viewData('tabs')->pluck('label')->toArray();

        $this->assertContains('Parent Tab', $labels);
        $this->assertContains('Child Tab', $labels);
        $this->assertNotContains('Other Tab', $labels);

        $response = $this->actingAs($user)->get(route('tabs.index', [
            'type' => 'link'
        ]));
        $response->assertStatus(200);
        $labels = $response->viewData('tabs')->pluck('label')->toArray();

        $this->assertContains('Child Tab', $labels);
        $this->assertContains('Other Tab', $labels);
        $this->assertNotContains('Parent Tab', $labels);

        $response = $this->actingAs($user)->get(route('tabs.index', [
            'type' => 'group'
        ]));
        $response->assertStatus(200);
        $labels = $response->viewData('tabs')->pluck('label')->toArray();

        $this->assertContains('Parent Tab', $labels);
        $this->assertNotContains('Child Tab', $labels);
        $this->assertNotContains('Other Tab', $labels);
    }

}
