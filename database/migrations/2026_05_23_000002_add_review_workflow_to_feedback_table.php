<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('feedback')) {
            return;
        }

        $addedReviewStatus = ! Schema::hasColumn('feedback', 'review_status');

        Schema::table('feedback', function (Blueprint $table) {
            if (! Schema::hasColumn('feedback', 'review_status')) {
                $reviewStatus = $table->enum('review_status', ['pending', 'approved', 'rejected'])
                    ->default('pending');

                if (Schema::hasColumn('feedback', 'updated_at')) {
                    $reviewStatus->after('updated_at');
                }
            }

            if (! Schema::hasColumn('feedback', 'reviewed_by')) {
                $table->unsignedBigInteger('reviewed_by')->nullable()->after('review_status');
            }

            if (! Schema::hasColumn('feedback', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
            }

            if (! Schema::hasColumn('feedback', 'review_note')) {
                $table->text('review_note')->nullable()->after('reviewed_at');
            }
        });

        if ($addedReviewStatus) {
            DB::table('feedback')->update(['review_status' => 'approved']);

            return;
        }

        DB::table('feedback')
            ->whereNull('review_status')
            ->orWhere('review_status', '')
            ->update(['review_status' => 'approved']);
    }

    public function down(): void
    {
        if (! Schema::hasTable('feedback')) {
            return;
        }

        Schema::table('feedback', function (Blueprint $table) {
            foreach (['review_note', 'reviewed_at', 'reviewed_by', 'review_status'] as $column) {
                if (Schema::hasColumn('feedback', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
