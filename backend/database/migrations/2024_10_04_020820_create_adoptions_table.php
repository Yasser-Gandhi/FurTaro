<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adoptions', function (Blueprint $table) {
            $table->id('adoption_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->foreignId('pet_id')->constrained('pets', 'pet_id')->onDelete('cascade');
            $table->enum('status', ['active', 'returned', 'completed'])->default('active');
            $table->timestamp('adoption_date');
            $table->timestamp('end_date')->nullable();
            $table->text('end_reason')->nullable();
            $table->timestamps();

            // Asegura que un animal solo pueda tener una adopción activa a la vez
            $table->unique(['pet_id', 'status'], 'unique_active_adoption')->where('status', 'active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adoptions');
    }
};
