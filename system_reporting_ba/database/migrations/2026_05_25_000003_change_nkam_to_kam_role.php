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
        // Add 'kam' to the enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'ba', 'rbs', 'nkam', 'kam', 'view user only') DEFAULT 'ba'");
        
        // Update existing 'nkam' users to 'kam'
        DB::table('users')->where('role', 'nkam')->update(['role' => 'kam']);
        
        // Remove 'nkam' from the enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'ba', 'rbs', 'kam', 'view user only') DEFAULT 'ba'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add 'nkam' back
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'ba', 'rbs', 'nkam', 'kam', 'view user only') DEFAULT 'ba'");
        
        // Revert 'kam' to 'nkam'
        DB::table('users')->where('role', 'kam')->update(['role' => 'nkam']);
        
        // Remove 'kam'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'ba', 'rbs', 'nkam', 'view user only') DEFAULT 'ba'");
    }
};
