<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\SmHumanDepartment;
use App\Models\Tab;

class DepartmentTest extends TestCase
{

    public function testIndex(): void
    {
        $user = $this->actingAsAdminWithPermissions();
        
        SmHumanDepartment::create(['name' => 'HR Department']);
        SmHumanDepartment::create(['name' => 'IT Department']);

        $response = $this->actingAs($user)->get(route('departments.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.departments.index');
        $response->assertSee('HR Department');
        $response->assertSee('IT Department');
    }

    public function testIndexSearch(): void
    {
        $user = $this->actingAsAdminWithPermissions();
        
        SmHumanDepartment::create(['name' => 'HR Department']);
        SmHumanDepartment::create(['name' => 'IT Department']);

        $response = $this->actingAs($user)->get(route('departments.index', ['search' => 'HR']));

        $response->assertStatus(200);
        $response->assertSee('HR Department');
        $response->assertDontSee('IT Department');
    }

    public function testEdit(): void
    {
        $user = $this->actingAsAdminWithPermissions();
        
        $department = SmHumanDepartment::create(['name' => 'HR Department']);
        
        $tab = Tab::create([
            'label' => 'Employee List',
            'url' => '/employees',
            'order' => 1
        ]);

        $response = $this->actingAs($user)->get(route('departments.edit', $department->id));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.departments.edit');
        $response->assertViewHas('department');
        $response->assertViewHas('tabs');
        $response->assertSee('Employee List');
    }

    public function testUpdateSyncTabs(): void
    {
        $user = $this->actingAsAdminWithPermissions();
        
        $department = SmHumanDepartment::create(['name' => 'HR Department']);
        
        $tab1 = Tab::create(['label' => 'Tab 1', 'url' => '/1', 'order' => 1]);
        $tab2 = Tab::create(['label' => 'Tab 2', 'url' => '/2', 'order' => 2]);

        $response = $this->actingAs($user)->put(route('departments.update', $department->id), [
            'tabs' => [$tab1->id, $tab2->id],
            'orders' => [
                $tab1->id => 10,
                $tab2->id => 20
            ]
        ]);

        $response->assertRedirect(route('departments.index'));
        $response->assertSessionHas('success', 'Department updated successfully with tabs.');

        $this->assertEquals(2, $department->tabs()->count());
        
        $pivot1 = $department->tabs()->find($tab1->id)->pivot;
        $pivot2 = $department->tabs()->find($tab2->id)->pivot;

        $this->assertEquals(10, $pivot1->order);
        $this->assertEquals(20, $pivot2->order);
    }

}
