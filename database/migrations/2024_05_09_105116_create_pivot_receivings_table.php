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
        Schema::create('pivot_receivings', function (Blueprint $table) {
            $table->id();
            $table->string('receiving_transaksi');
            $table->string('item_sku');
            $table->integer('jumlah');
            $table->timestamps();

            $table->foreign('receiving_transaksi')->references('no_transaksi')->on('receivings')->onDelete('cascade');
            $table->foreign('item_sku')->references('sku')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pivot_receivings');
    }
};
