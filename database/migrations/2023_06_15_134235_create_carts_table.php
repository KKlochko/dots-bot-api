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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('city_id')->unsigned();
            $table->unsignedBiginteger('company_id')->unsigned();
            $table->unsignedBiginteger('user_id')->unsigned();
            $table->string('status'); // CART | DONE

            $table->foreign('city_id')->references('id')
                 ->on('cities')->onDelete('cascade');
            $table->foreign('company_id')->references('id')
                 ->on('companies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')
                 ->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};