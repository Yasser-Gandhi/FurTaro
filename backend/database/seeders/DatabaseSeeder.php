<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log; // Importa Log
use App\Models\Shelter;
use App\Models\User;
use App\Models\Pet;
use App\Models\Favorite;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear refugios
        $shelters = Shelter::factory(7)->create(); // Crea 7 refugios
        Log::info('Refugios creados: ' . $shelters->count());

        // Crear usuarios
        $users = User::factory(10)->create();
        Log::info('Usuarios creados: ' . $users->count());

        // Crear mascotas y asociarlas a cada refugio
        foreach ($shelters as $shelter) {
            Log::info('Creando mascotas para refugio ID: ' . $shelter->id);
            try {
                $pets = Pet::factory(6)->create(['shelter_id' => $shelter->id]);
                Log::info('Mascotas creadas para refugio ID ' . $shelter->id . ': ' . $pets->count());
            } catch (\Exception $e) {
                Log::error('Error creando mascotas para refugio ID ' . $shelter->id . ': ' . $e->getMessage());
            }
        }
        
        

        // Crear favoritos para cada usuario
        foreach ($users as $user) {
            $favoritesData = [];
            for ($i = 0; $i < 3; $i++) {
                // Asegúrate de que haya mascotas disponibles
                if (Pet::count() > 0) {
                    $petId = Pet::inRandomOrder()->first()->id; // Selecciona una mascota aleatoria
                    $favoritesData[] = [
                        'user_id' => $user->id,
                        'pet_id' => $petId,
                    ];
                }
            }
            // Solo inserta si hay datos
            if (!empty($favoritesData)) {
                Favorite::insert($favoritesData);
            }
        }

        // Crear un usuario de prueba
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Log::info('Usuario de prueba creado: Test User');
    }
}
