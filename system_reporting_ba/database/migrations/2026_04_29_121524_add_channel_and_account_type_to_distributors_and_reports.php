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
        Schema::table('distributors', function (Blueprint $table) {
            $table->string('channel')->nullable()->after('name');
            $table->string('account_type')->nullable()->after('channel');
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->string('channel')->nullable()->after('account_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distributors', function (Blueprint $table) {
            $table->dropColumn(['channel', 'account_type']);
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('channel');
        });
    }
};
