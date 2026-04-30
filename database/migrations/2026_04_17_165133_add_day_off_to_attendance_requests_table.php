<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE attendance_requests MODIFY COLUMN type ENUM('check-in', 'check-out', 'day-off') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverting enum changes correctly
        DB::statement("ALTER TABLE attendance_requests MODIFY COLUMN type ENUM('check-in', 'check-out') NOT NULL");
    }
};
