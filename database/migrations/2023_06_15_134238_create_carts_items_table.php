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
        Schema::create('carts_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('cart_id')->unsigned();
            $table->unsignedBiginteger('item_id')->unsigned();

            $table->foreign('cart_id')->references('id')
                 ->on('carts')->onDelete('cascade');
            $table->foreign('item_id')->references('id')
                ->on('items')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts_items');
    }
};
