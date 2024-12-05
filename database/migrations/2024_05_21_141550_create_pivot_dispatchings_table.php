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
        Schema::create('pivot_dispatchings', function (Blueprint $table) {
            $table->id();
            $table->string('dispatching_transaksi');
            $table->string('item_sku');
            $table->integer('jumlah');
            $table->timestamps();

            $table->foreign('dispatching_transaksi')->references('no_transaksi')->on('dispatchings')->onDelete('cascade');
            $table->foreign('item_sku')->references('sku')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pivot_dispatchings');
    }
};
