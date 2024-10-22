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
            $table->id('pet_id'); // Clave primaria de la tabla 'pets'
            $table->string('name');
            $table->string('species', 50);
            $table->integer('age');
            $table->longText('description');
            $table->foreignId('shelter_id')->constrained('shelters', 'shelter_id');
            $table->enum('status', ['disponible', 'adoptado'])->default('disponible');
            $table->timestamps(); // created_at and updated_at
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
