<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained('it_vendors')->cascadeOnDelete();
            $table->timestamps();
        });
        Schema::table('purchases', function (Blueprint $table) {
            if (Schema::hasColumn('purchases', 'vendor_details')) {
                $table->dropColumn('vendor_details');
            }
        });
    }
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->text('vendor_details')->nullable();
        });
        Schema::dropIfExists('purchase_vendors');
    }
};
