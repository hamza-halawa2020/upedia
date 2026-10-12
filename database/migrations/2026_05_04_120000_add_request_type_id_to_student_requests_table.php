<?php

use App\Models\RequestType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {
            $table->foreignId('request_type_id')->nullable()->constrained('request_types')->nullOnDelete();
        });

    }

    public function down(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('request_type_id');
        });
    }
};
