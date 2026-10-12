<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\TicketPriority;
use App\Models\Staff;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('ticket_priority_id')->nullable()->after('ticket_item_id');
            $table->unsignedBigInteger('assigned_to')->nullable()->after('ticket_priority_id');
            $table->unsignedBigInteger('requester_id')->nullable()->after('assigned_to');
            $table->string('status')->default('open')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->after('request_type');
            $table->dropForeign(['ticket_priority_id']);
            $table->dropColumn('ticket_priority_id');
            $table->dropForeign(['requester_id']);
            $table->dropColumn('requester_id');
            $table->dropForeign(['assigned_to']);
            $table->dropColumn('assigned_to');
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open')->change();
        });
    }
};
