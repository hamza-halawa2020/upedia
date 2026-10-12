<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['feedback', 'retention_feedback'] as $tableName) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            $addedReviewStatus = ! Schema::hasColumn($tableName, 'review_status');

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (! Schema::hasColumn($tableName, 'review_status')) {
                    $reviewStatus = $table->enum('review_status', ['pending', 'approved', 'rejected'])
                        ->default('pending');

                    if (Schema::hasColumn($tableName, 'updated_at')) {
                        $reviewStatus->after('updated_at');
                    }
                }

                if (! Schema::hasColumn($tableName, 'reviewed_by')) {
                    $table->unsignedBigInteger('reviewed_by')->nullable()->after('review_status');
                }

                if (! Schema::hasColumn($tableName, 'reviewed_at')) {
                    $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
                }

                if (! Schema::hasColumn($tableName, 'review_note')) {
                    $table->text('review_note')->nullable()->after('reviewed_at');
                }
            });

            if ($addedReviewStatus) {
                DB::table($tableName)->update(['review_status' => 'approved']);
            } else {
                DB::table($tableName)
                    ->whereNull('review_status')
                    ->orWhere('review_status', '')
                    ->update(['review_status' => 'approved']);
            }
        }
    }

    public function down(): void
    {
        foreach (['feedback', 'retention_feedback'] as $tableName) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                foreach (['review_note', 'reviewed_at', 'reviewed_by', 'review_status'] as $column) {
                    if (Schema::hasColumn($tableName, $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
