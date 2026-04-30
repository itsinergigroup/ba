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
            $table->dropForeign(['user_id']);
            $table->dropForeign(['distributor_id']);
            $table->dropForeign(['outlet_id']);
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['product_id']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('distributor_id')->references('id')->on('distributors')->onDelete('cascade');
            $table->foreign('outlet_id')->references('id')->on('outlets')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['distributor_id']);
            $table->dropForeign(['outlet_id']);
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['product_id']);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('distributor_id')->references('id')->on('distributors');
            $table->foreign('outlet_id')->references('id')->on('outlets');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }
};
