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
        Schema::create('cities_companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('city_id')->unsigned();
            $table->unsignedBiginteger('company_id')->unsigned();

            $table->foreign('city_id')->references('id')
                 ->on('cities')->onDelete('cascade');
            $table->foreign('company_id')->references('id')
                ->on('companies')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities_companies');
    }
};
