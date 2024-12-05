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
        Schema::create('lotforlots', function (Blueprint $table) {
            $table->id();
            $table->string('item_sku');
            $table->integer('jan_feb');
            $table->integer('mar_apr');
            $table->integer('mei_jun');
            $table->integer('jul_agt');
            $table->integer('sep_okt');
            $table->integer('nov_des');
            $table->timestamps();

            $table->foreign('item_sku')->references('sku')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotforlots');
    }
};
