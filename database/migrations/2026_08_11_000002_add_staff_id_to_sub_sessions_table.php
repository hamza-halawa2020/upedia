<?php

use App\Models\Staff;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('sub_sessions', 'staff_id')) {
            Schema::table('sub_sessions', function (Blueprint $table) {
                $table->foreignIdFor(Staff::class, 'staff_id')
                    ->nullable()
                    ->after('staff_scheduled_id')
                    ->constrained('sm_staffs')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('sub_sessions', 'staff_id')) {
            Schema::table('sub_sessions', function (Blueprint $table) {
                $table->dropConstrainedForeignId('staff_id');
            });
        }
    }
};
