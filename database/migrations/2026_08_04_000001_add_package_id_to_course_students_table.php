<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_students', function (Blueprint $table) {
            if (! Schema::hasColumn('course_students', 'package_id')) {
                $table->foreignId('package_id')
                    ->nullable()
                    ->after('course_id')
                    ->constrained('packages')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('course_students', function (Blueprint $table) {
            if (Schema::hasColumn('course_students', 'package_id')) {
                $table->dropConstrainedForeignId('package_id');
            }
        });
    }
};
