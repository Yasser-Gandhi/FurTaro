<?php

use Illuminate\Database\Seeder;
use App\Models\Pet;
use App\Models\Favorite;

class FavoriteSeeder extends Seeder
{
    public function run()
    {
        // Obtén todos los IDs de mascotas
        $pets = Pet::all()->pluck('id');

        // Verifica si hay mascotas disponibles
        if ($pets->isNotEmpty()) {
            foreach ($pets as $petId) {
                // Crea un nuevo registro en la tabla 'favorites'
                Favorite::factory()->create([
                    'pet_id' => $petId, // Asigna un pet_id válido
                    'user_id' => 1, // Asigna un user_id válido
                ]);
            }
        } else {
            // Maneja el caso donde no hay mascotas
            \Log::info('No hay mascotas disponibles para agregar a favoritos.');
        }
    }
}
