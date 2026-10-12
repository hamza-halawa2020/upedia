<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('applicant_staff_session_slot')) {
            Schema::create('applicant_staff_session_slot', function (Blueprint $table) {
                $table->id();
                $table->foreignId('staff_session_slot_id')->constrained('staff_session_slots')->onDelete('cascade');
                $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');
                $table->timestamps();
            });
        }

        // Migrate existing data if pivot is empty
        if (DB::table('applicant_staff_session_slot')->count() === 0) {
            $slots = DB::table('staff_session_slots')->whereNotNull('applicant_id')->get();
            foreach ($slots as $slot) {
                DB::table('applicant_staff_session_slot')->insert([
                    'staff_session_slot_id' => $slot->id,
                    'applicant_id' => $slot->applicant_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Drop the old column if it exists
        if (Schema::hasColumn('staff_session_slots', 'applicant_id')) {
            Schema::table('staff_session_slots', function (Blueprint $table) {
                // Dynamically find FK name
                $foreignKeys = DB::select("
                    SELECT CONSTRAINT_NAME 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = 'staff_session_slots' 
                    AND COLUMN_NAME = 'applicant_id'
                    AND REFERENCED_TABLE_NAME IS NOT NULL
                ");

                if (!empty($foreignKeys)) {
                    $fkName = $foreignKeys[0]->CONSTRAINT_NAME;
                    $table->dropForeign($fkName);
                }

                $table->dropColumn('applicant_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('staff_session_slots', 'applicant_id')) {
            Schema::table('staff_session_slots', function (Blueprint $table) {
                $table->foreignId('applicant_id')->nullable()->constrained('applicants')->onDelete('cascade');
            });

            // Restore data (take the first one found)
            if (Schema::hasTable('applicant_staff_session_slot')) {
                $pivots = DB::table('applicant_staff_session_slot')->get();
                foreach ($pivots as $pivot) {
                    DB::table('staff_session_slots')
                        ->where('id', $pivot->staff_session_slot_id)
                        ->update(['applicant_id' => $pivot->applicant_id]);
                }
            }
        }

        Schema::dropIfExists('applicant_staff_session_slot');
    }
};
