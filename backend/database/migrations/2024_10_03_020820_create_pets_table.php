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
        Schema::create('pets', function (Blueprint $table) {
            $table->bigIncrements('pet_id'); // Clave primaria para 'pets'
            $table->string('name');
            $table->string('species');
            $table->integer('age');
            $table->string('description');
            $table->unsignedBigInteger('shelter_id'); // Define 'shelter_id' como unsignedBigInteger
            $table->foreign('shelter_id')->references('shelter_id')->on('shelters')->onDelete('cascade'); // Referencia a 'shelter_id' en 'shelters'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
