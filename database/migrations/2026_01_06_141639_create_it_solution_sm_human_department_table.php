<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('it_solution_sm_human_department', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('it_solution_id');
            $table->unsignedBigInteger('sm_human_department_id');

            $table->foreign('it_solution_id', 'fk_it_solution')
                ->references('id')
                ->on('it_solutions')
                ->cascadeOnDelete();

            $table->foreign('sm_human_department_id', 'fk_sm_human_department')
                ->references('id')
                ->on('sm_human_departments')
                ->cascadeOnDelete();

            $table->unique(
                ['it_solution_id', 'sm_human_department_id'],
                'ux_it_solution_department'
            );
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('it_solution_sm_human_department');
    }
};
