<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pet;
use App\Models\Favorite;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuarios
        $users = User::factory(10)->create();

        // Crear mascotas
        $pets = Pet::factory(20)->create();

        // Crear favoritos para cada usuario
        foreach ($users as $user) {
            // Crear 3 favoritos para cada usuario
            for ($i = 0; $i < 3; $i++) {
                Favorite::factory()->create([
                    'user_id' => $user->id,
                    'pet_id' => $pets->random()->id, // Asocia una mascota aleatoria
                ]);
            }
        }

        // Crear un usuario de prueba
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
