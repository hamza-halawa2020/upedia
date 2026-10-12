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
        Schema::table('applicants', function (Blueprint $table) {
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->enum('offline_training', ['attended', 'not_attended'])->nullable();
            $table->boolean('second_interview_done')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn(['staff_id', 'offline_training', 'second_interview_done']);
        });
    }
};
