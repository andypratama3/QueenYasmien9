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
            $table->foreignUuId('pemesanan_id')->references('id')->on('pemesanans');
            $table->integer('qty')->default(1);
            $table->primary(['product_id', 'pemesanan_id']);
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
