<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('placement_test_bookings')) {
            Schema::create('placement_test_bookings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('course_student_id')->constrained('course_students')->cascadeOnDelete();
                $table->unsignedBigInteger('student_id');
                $table->string('assessment_type');
                $table->string('status')->default('booked');
                $table->foreignId('staff_scheduled_id')->nullable()->constrained('staff_scheduleds')->nullOnDelete();
                $table->foreignId('scheduled_session_id')->nullable()->constrained('scheduled_sessions')->nullOnDelete();
                $table->unsignedBigInteger('staff_id')->nullable();
                $table->date('session_date')->nullable();
                $table->time('start_time')->nullable();
                $table->time('end_time')->nullable();
                $table->timestamp('reminders_scheduled_at')->nullable();
                $table->timestamp('session_day_10am_reminded_at')->nullable();
                $table->timestamp('one_hour_before_reminded_at')->nullable();
                $table->timestamp('ten_minutes_before_reminded_at')->nullable();
                $table->timestamps();

                $table->unique('course_student_id', 'placement_unique_enrollment');
                $table->foreign('student_id')->references('id')->on('sm_students')->cascadeOnDelete();
                $table->foreign('staff_id')->references('id')->on('sm_staffs')->nullOnDelete();
            });
        } else {
            $this->repairPartiallyCreatedPlacementTable();
        }

        if (! Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('type');
                $table->morphs('notifiable');
                $table->text('data');
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('placement_test_bookings');
    }

    private function repairPartiallyCreatedPlacementTable(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement('ALTER TABLE placement_test_bookings MODIFY student_id INT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE placement_test_bookings MODIFY staff_id INT UNSIGNED NULL');

        $this->addIndexIfMissing('placement_test_bookings_student_id_index', 'student_id');
        $this->addIndexIfMissing('placement_test_bookings_staff_scheduled_id_index', 'staff_scheduled_id');
        $this->addIndexIfMissing('placement_test_bookings_scheduled_session_id_index', 'scheduled_session_id');
        $this->addIndexIfMissing('placement_test_bookings_staff_id_index', 'staff_id');
        $this->addUniqueIfMissing('placement_unique_enrollment', 'course_student_id');

        $this->addForeignKeyIfMissing('placement_test_bookings_student_id_foreign', 'student_id', 'sm_students', 'id', 'CASCADE');
        $this->addForeignKeyIfMissing('placement_test_bookings_staff_scheduled_id_foreign', 'staff_scheduled_id', 'staff_scheduleds', 'id', 'SET NULL');
        $this->addForeignKeyIfMissing('placement_test_bookings_scheduled_session_id_foreign', 'scheduled_session_id', 'scheduled_sessions', 'id', 'SET NULL');
        $this->addForeignKeyIfMissing('placement_test_bookings_staff_id_foreign', 'staff_id', 'sm_staffs', 'id', 'SET NULL');
    }

    private function addIndexIfMissing(string $indexName, string $column): void
    {
        if ($this->indexExists($indexName)) {
            return;
        }

        DB::statement("ALTER TABLE placement_test_bookings ADD INDEX {$indexName} ({$column})");
    }

    private function addUniqueIfMissing(string $indexName, string $column): void
    {
        if ($this->indexExists($indexName)) {
            return;
        }

        DB::statement("ALTER TABLE placement_test_bookings ADD UNIQUE {$indexName} ({$column})");
    }

    private function addForeignKeyIfMissing(string $constraintName, string $column, string $referenceTable, string $referenceColumn, string $onDelete): void
    {
        if ($this->foreignKeyExists($constraintName)) {
            return;
        }

        DB::statement(
            "ALTER TABLE placement_test_bookings ADD CONSTRAINT {$constraintName} FOREIGN KEY ({$column}) REFERENCES {$referenceTable} ({$referenceColumn}) ON DELETE {$onDelete}"
        );
    }

    private function indexExists(string $indexName): bool
    {
        return DB::table('information_schema.STATISTICS')
            ->whereRaw('TABLE_SCHEMA = DATABASE()')
            ->where('TABLE_NAME', 'placement_test_bookings')
            ->where('INDEX_NAME', $indexName)
            ->exists();
    }

    private function foreignKeyExists(string $constraintName): bool
    {
        return DB::table('information_schema.KEY_COLUMN_USAGE')
            ->whereRaw('TABLE_SCHEMA = DATABASE()')
            ->where('TABLE_NAME', 'placement_test_bookings')
            ->where('CONSTRAINT_NAME', $constraintName)
            ->whereNotNull('REFERENCED_TABLE_NAME')
            ->exists();
    }
};
