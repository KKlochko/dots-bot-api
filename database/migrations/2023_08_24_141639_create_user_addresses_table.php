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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->smallInteger('type')->default(0);
            $table->string('street', 255);
            $table->string('house', 10)->nullable();
            $table->string('flat', 10)->nullable();
            $table->string('stage', 10)->nullable();
            $table->string('note', 100);

            $table->unsignedBiginteger('city_id')->unsigned();
            $table->unsignedBiginteger('user_id')->unsigned();

            $table->foreign('city_id')->references('id')
                 ->on('cities')->onDelete('cascade');

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
        Schema::dropIfExists('user_addresses');
    }
};
