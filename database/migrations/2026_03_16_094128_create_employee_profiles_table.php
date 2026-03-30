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
        Schema::create('employee_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nik', 30)->nullable();
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable();
            $table->date('dob')->nullable();
            $table->text('address')->nullable();
            $table->string('phone', 20)->nullable();
            $table->enum('employment_status', ['Tetap', 'Kontrak', 'Magang'])->nullable();
            $table->date('join_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_profiles');
    }
};
