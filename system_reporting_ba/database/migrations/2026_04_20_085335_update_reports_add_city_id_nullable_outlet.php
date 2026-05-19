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
        Schema::table('reports', function (Blueprint $table) {
            // Add city_id as nullable (reports will now store city directly)
            $table->unsignedBigInteger('city_id')->nullable()->after('outlet_id');
            $table->foreign('city_id')->references('id')->on('cities')->nullOnDelete();
            // Make outlet_id nullable (no longer required on new reports)
            $table->unsignedBigInteger('outlet_id')->nullable()->change();
        });
    }
    

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
            $table->unsignedBigInteger('outlet_id')->nullable(false)->change();
        });
    }
};
