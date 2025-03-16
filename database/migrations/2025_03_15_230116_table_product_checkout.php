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
        Schema::create('product_checkout', function (Blueprint $table) {
            $table->foreignUuId('product_id')->references('id')->on('products');
            $table->foreignUuId('pemesanans_id')->references('id')->on('pemesanans');

            $table->primary(['product_id', 'pemesanans_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_checkout');
    }
};
