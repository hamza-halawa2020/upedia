<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('product');
            $table->string('model');
            $table->string('serial_number');
            $table->string('manufacturer')->nullable();
            $table->string('vendor');
            $table->string('barcode')->nullable();
            $table->decimal('purchase_cost', 15, 2);
            $table->date('acquisition_date');
            $table->date('warranty_expiry_date')->nullable();
            $table->string('site')->nullable();
            $table->foreignId('department_id')->nullable()->constrained('sm_human_departments')->onDelete('set null');
            $table->enum('is_currently_in_use', ['in_use', 'in_store', 'in_repair'])
                ->default('in_store');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('processor')->nullable();
            $table->integer('ram')->nullable();
            $table->string('hard_disk')->nullable();
            $table->boolean('has_keyboard')->default(false);
            $table->boolean('has_mouse')->default(false);
            $table->boolean('has_monitor')->default(false);
            $table->boolean('has_headphone')->default(false);
            $table->boolean('has_bag')->default(false);
            $table->boolean('has_usb_flash')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
