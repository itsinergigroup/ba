<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('outlet_user', function (Blueprint $row) {
            $row->id();
            $row->foreignId('user_id')->constrained()->onDelete('cascade');
            $row->foreignId('outlet_id')->constrained()->onDelete('cascade');
            $row->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outlet_user');
    }
};
