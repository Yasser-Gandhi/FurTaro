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
        Schema::create('adoptions', function (Blueprint $table) {
            $table->id('adoption_id'); // Clave primaria de la tabla 'adoptions'
            $table->foreignId('user_id')->constrained('users', 'user_id'); // Ajusta la clave foránea a 'user_id'
            $table->foreignId('pet_id')->constrained('pets', 'pet_id'); // Ajusta la clave foránea a 'pet_id'
            $table->timestamp('adoption_date');
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoptions');
    }
};
