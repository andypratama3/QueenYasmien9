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
            $table->string('order_id');
            $table->integer('gross_amount');
            $table->string('pengiriman')->nullable();
            $table->text('alamat');
            $table->enum('status_pemesanan', ['pending','selesai','cancel','proses','pengiriman'])->default('pending');
            $table->string('status_pembayaran')->default('pending');
            $table->foreignUuId('user_id')->references('id')->on('users');
            $table->foreignUuId('products_reseller_id')->nullable()->references('id')->on('products_reseller');
            $table->string('snap_token')->nullable();
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
