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
            $table->bigIncrements('favorite_id'); // Clave primaria autoincremental para 'favorites'
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade'); // Referencia a 'user_id' en 'users'
            $table->foreignId('pet_id')->constrained('pets', 'pet_id')->onDelete('cascade'); // Clave foránea para 'pet_id'
            $table->boolean('is_favorite')->default(false); // Nuevo campo booleano para controlar la actividad
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
