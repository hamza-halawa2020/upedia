<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('payments')) {
            return;
        }

        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'receipt_image')) {
                $table->string('receipt_image')->nullable();
            }

            if (!Schema::hasColumn('payments', 'approval_status')) {
                $table->string('approval_status', 20)->default('pending')->index();
            }

            if (!Schema::hasColumn('payments', 'approved_at')) {
                $table->timestamp('approved_at')->nullable();
            }

            if (!Schema::hasColumn('payments', 'approved_by')) {
                $table->foreignIdFor(User::class, 'approved_by')->nullable()->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('payments', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable();
            }

            if (!Schema::hasColumn('payments', 'rejected_by')) {
                $table->foreignIdFor(User::class, 'rejected_by')->nullable()->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('payments', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable();
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('payments')) {
            return;
        }

        Schema::table('payments', function (Blueprint $table) {
            foreach (['approved_by', 'rejected_by'] as $column) {
                if (Schema::hasColumn('payments', $column)) {
                    $table->dropConstrainedForeignId($column);
                }
            }

            foreach (['receipt_image', 'approval_status', 'approved_at', 'rejected_at', 'rejection_reason'] as $column) {
                if (Schema::hasColumn('payments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
