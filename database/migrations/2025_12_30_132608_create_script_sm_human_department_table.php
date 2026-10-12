<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scripts', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropColumn('department_id');
        });
        Schema::create('script_sm_human_department', function (Blueprint $table) {
            $table->id();
            $table->foreignId('script_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sm_human_department_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('script_sm_human_department');
        Schema::table('scripts', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('sm_human_departments')->onDelete('cascade');
        });
    }
};
