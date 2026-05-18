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
        Schema::create('distributors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address')->nullable();
            $table->timestamps();
        });

        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained();
            $table->string('name');
            $table->decimal('het', 15, 2);
            $table->timestamps();
        });

        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('province_id')->constrained();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('outlets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('city_id')->constrained();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->date('date');
            $table->foreignId('distributor_id')->constrained();
            $table->string('account_type'); // GT/MT
            $table->foreignId('outlet_id')->constrained();
            $table->foreignId('brand_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->integer('quantity');
            $table->decimal('het', 15, 2);
            $table->decimal('unit_price', 15, 2);
            $table->decimal('discount', 5, 2); // Percentage
            $table->decimal('total_price', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
        Schema::dropIfExists('outlets');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('products');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('distributors');
    }
};
