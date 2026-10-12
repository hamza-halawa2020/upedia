<?php

use App\Models\Lead;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('lead_assignments')) {
            Schema::create('lead_assignments', function (Blueprint $table) {
                $table->id();
                $table->foreignIdFor(Lead::class, 'lead_id')->constrained('crm_leads')->cascadeOnDelete();
                $table->unsignedBigInteger('staff_id')->nullable();
                $table->foreignIdFor(User::class, 'assigned_by')->nullable()->constrained('users')->nullOnDelete();
                $table->string('assignment_type');
                $table->string('shift_type')->nullable();
                $table->string('reason')->nullable();
                $table->timestamp('assigned_at');
                $table->timestamps();

                $table->index('lead_id');
                $table->index('staff_id');
                $table->index('assignment_type');
                $table->index('shift_type');
                $table->index('assigned_at');

                $table->foreign('staff_id')->references('id')->on('sm_staffs')->nullOnDelete();
            });
        }

        Schema::table('crm_leads', function (Blueprint $table) {
            if (! Schema::hasColumn('crm_leads', 'assigned_staff_id')) {
                $table->unsignedBigInteger('assigned_staff_id')->nullable()->after('assigned_to');
                $table->foreign('assigned_staff_id')->references('id')->on('sm_staffs')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('crm_leads', function (Blueprint $table) {
            if (Schema::hasColumn('crm_leads', 'assigned_staff_id')) {
                $table->dropConstrainedForeignId('assigned_staff_id');
            }
        });

        Schema::dropIfExists('lead_assignments');
    }
};
