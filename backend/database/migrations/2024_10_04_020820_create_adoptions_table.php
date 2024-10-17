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
            $table->bigIncrements('adoption_id'); // Clave primaria para 'adoptions'
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade'); // Clave foránea a 'users'
            $table->foreignId('pet_id')->constrained('pets', 'pet_id')->onDelete('cascade'); // Clave foránea a 'pets'
            $table->timestamps();
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
