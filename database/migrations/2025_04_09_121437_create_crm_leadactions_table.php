<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('crm_leadactions', function (Blueprint $table) {
            $table->id();
            $table->enum('action',['payment','call','test','task','demo','product','reschedule']);
            $table->bigInteger('workflow_id')->nullable();
            // $table->foreignId('workflow_id')
            //       ->nullable()  
            //       ->constrained('crm_work_flows')
            //       ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_leadactions');
    }
};
