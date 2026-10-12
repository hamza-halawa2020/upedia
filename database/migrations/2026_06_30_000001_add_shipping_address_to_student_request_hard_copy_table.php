<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_request_hard_copy', function (Blueprint $table) {
            if (! Schema::hasColumn('student_request_hard_copy', 'shipping_address')) {
                $table->text('shipping_address')->nullable()->after('delivery_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('student_request_hard_copy', function (Blueprint $table) {
            if (Schema::hasColumn('student_request_hard_copy', 'shipping_address')) {
                $table->dropColumn('shipping_address');
            }
        });
    }
};
