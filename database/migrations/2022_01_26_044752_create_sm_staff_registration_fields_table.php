<?php

use App\SmSchool;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Models\SmStaffRegistrationField;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\InfixModuleInfo;

class CreateSmStaffRegistrationFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_staff_registration_fields', function (Blueprint $table) {
            $table->id();
            $table->string('field_name')->nullable();
            $table->string('label_name')->nullable();                
            $table->tinyInteger('active_status')->nullable()->default(1);
            $table->tinyInteger('is_required')->nullable()->default(0);
            $table->tinyInteger('staff_edit')->nullable()->default(0);           
            $table->tinyInteger('required_type')->nullable()->comment('1=switch on,2=off');
            $table->integer('position')->nullable();
            
            $table->unsignedInteger('created_by')->nullable()->default(1);
            $table->unsignedInteger('updated_by')->nullable()->default(1);


            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_staff_registration_fields');
    }
}
