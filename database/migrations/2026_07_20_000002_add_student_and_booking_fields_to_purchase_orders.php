<?php

use App\Models\Student;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('purchases') && !Schema::hasColumn('purchases', 'student_id')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->foreignIdFor(Student::class)->nullable()->after('party_type')->constrained()->nullOnDelete();
            });
        }

        if (Schema::hasTable('purchase_details') && !Schema::hasColumn('purchase_details', 'booking_id')) {
            Schema::table('purchase_details', function (Blueprint $table) {
                $table->unsignedBigInteger('booking_id')->nullable()->after('purchase_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('purchase_details') && Schema::hasColumn('purchase_details', 'booking_id')) {
            Schema::table('purchase_details', function (Blueprint $table) {
                $table->dropColumn('booking_id');
            });
        }

        if (Schema::hasTable('purchases') && Schema::hasColumn('purchases', 'student_id')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->dropConstrainedForeignId('student_id');
            });
        }
    }
};
