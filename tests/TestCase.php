<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Tab;
use Illuminate\Http\UploadedFile;
abstract class TestCase extends BaseTestCase
{

    protected function setUp(): void
    {  
        parent::setUp();
        $this->artisan('config:clear');
        
        $this->createTables();
    }
    
    protected function createTables(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');
        }); 
        
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->timestamps();
        }); 
        
         Schema::create('sm_staffs', function (Blueprint $table) {
            $table->boolean('active_status')->default(true);
            $table->id();
            $table->string('full_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });  

        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
        });

        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
        }); 

        Schema::create('tabs', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('url')->nullable();
            $table->string('icon')->nullable();
            $table->bigInteger('parent_id')->nullable();
            $table->string('permission_required')->nullable();
            $table->integer('order')->default(0);
            $table->longText('systems')->nullable();
            $table->timestamps();
        }); 

        Schema::create('sm_human_departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mail_alias')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('department_head_id')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });

        Schema::create('department_tab', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('tab_id');
            $table->integer('order')->default(0);
        });

    }

    protected function actingAsAdminWithPermissions()
    {
        $permissions = [
            'general_tabs_index',
            'general_tabs_update',
            'general_departments_index',
            'general_departments_update',
        ];

        $user = User::create([
            'full_name' => 'Super admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('123456'),
            'remember_token' => 'ascsc',
        ]);

        $role = Role::create([
            'name' => 'Super admin',
            'guard_name' => 'web',
        ]);

        $user->roles()->attach($role->id, [
            'model_type' => User::class,
        ]);

        foreach ($permissions as $perm) {
            $permission = Permission::create([
                'name' => $perm,
                'guard_name' => 'web',
            ]);

            $role->permissions()->attach($permission->id);
        }

        return $user;
    }

}