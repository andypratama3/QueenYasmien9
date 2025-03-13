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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('gross_amount');
            $table->integer('qty');
            $table->string('pengiriman')->nullable();
            $table->enum('status_pemesanan', ['pending','selesai','cancel'])->default('pending');
            $table->string('status_pembayaran');
            $table->foreignUuId('user_id')->references('id')->on('users');
            $table->foreignUuId('product_id')->references('id')->on('products');
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
