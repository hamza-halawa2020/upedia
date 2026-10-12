<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('student_requests', 'created_by_admin_id')) {
                $table->unsignedBigInteger('created_by_admin_id')->nullable()->after('created_by');
            }

            if (! Schema::hasColumn('student_requests', 'assigned_to_admin_id')) {
                $table->unsignedBigInteger('assigned_to_admin_id')->nullable()->after('created_by_admin_id');
            }

            if (! Schema::hasColumn('student_requests', 'assigned_to_department_id')) {
                $table->unsignedBigInteger('assigned_to_department_id')->nullable()->after('assigned_to_admin_id');
            }

            if (! Schema::hasColumn('student_requests', 'resolved_at')) {
                $table->timestamp('resolved_at')->nullable()->after('status_changed_by');
            }

            if (! Schema::hasColumn('student_requests', 'closed_at')) {
                $table->timestamp('closed_at')->nullable()->after('resolved_at');
            }
        });

        if (Schema::hasColumn('student_requests', 'status')) {
            if (DB::getDriverName() === 'mysql') {
                DB::statement("ALTER TABLE student_requests MODIFY status ENUM('pending','solved','unsolved','assigned','in_progress','resolved','rejected','closed') NOT NULL DEFAULT 'pending'");
            }

            DB::table('student_requests')->where('status', 'solved')->update(['status' => 'resolved']);
            DB::table('student_requests')->where('status', 'unsolved')->update(['status' => 'rejected']);

            if (DB::getDriverName() === 'mysql') {
                DB::statement("ALTER TABLE student_requests MODIFY status ENUM('pending','assigned','in_progress','resolved','rejected','closed') NOT NULL DEFAULT 'pending'");
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('student_requests', 'status') && DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE student_requests MODIFY status ENUM('pending','solved','unsolved','assigned','in_progress','resolved','rejected','closed') NOT NULL DEFAULT 'pending'");
            DB::table('student_requests')->where('status', 'resolved')->update(['status' => 'solved']);
            DB::table('student_requests')->whereIn('status', ['rejected', 'assigned', 'in_progress', 'closed'])->update(['status' => 'unsolved']);
            DB::statement("ALTER TABLE student_requests MODIFY status ENUM('pending','solved','unsolved') NOT NULL DEFAULT 'pending'");
        }

        Schema::table('student_requests', function (Blueprint $table) {
            foreach (['closed_at', 'resolved_at', 'assigned_to_department_id', 'assigned_to_admin_id', 'created_by_admin_id'] as $column) {
                if (Schema::hasColumn('student_requests', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
