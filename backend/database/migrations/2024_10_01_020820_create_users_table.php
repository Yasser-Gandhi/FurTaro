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
            $table->bigIncrements('user_id'); // Cambia 'id' por 'user_id' como clave primaria
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('contact_number');
            $table->string('location');
            $table->enum('role', ['user', 'admin', 'shelter_manager']);
            $table->timestamps();
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
