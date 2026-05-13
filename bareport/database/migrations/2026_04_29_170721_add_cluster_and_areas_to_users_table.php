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
        Schema::table('users', function (Blueprint $table) {
            $table->string('cluster')->nullable()->after('role');
            $table->text('areas')->nullable()->after('cluster'); // Store as JSON or comma separated
            $table->foreignId('rbs_id')->nullable()->after('areas')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['rbs_id']);
            $table->dropColumn(['cluster', 'areas', 'rbs_id']);
        });
    }
};
