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
        Schema::create('favorites', function (Blueprint $table) {
            $table->bigIncrements('favorite_id'); // Clave primaria para 'favorites'
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade'); // Referencia a 'user_id' en 'users'
            $table->unsignedBigInteger('pet_id'); // Clave foránea para 'pet_id'
            $table->foreign('pet_id')->references('pet_id')->on('pets')->onDelete('cascade'); // Referencia a 'pet_id' en 'pets'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
