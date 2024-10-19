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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id'); // Clave primaria de la tabla 'users'
            $table->string('name');
            $table->string('phone_number'); // Cambia el tipo de dato según tus necesidades
            $table->string('email', 50)->unique();
            $table->string('password');
            $table->timestamp('adoption_date')->nullable(); // Asegúrate de incluir esta columna
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
