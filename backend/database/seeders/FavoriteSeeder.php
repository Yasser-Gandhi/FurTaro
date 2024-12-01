<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pet;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear 5 usuarios aleatorios
        $users = User::factory()->count(5)->create();

        // Obtener todas las mascotas
        $pets = Pet::all();

        // Asignar aleatoriamente algunas mascotas como favoritas a cada usuario
        foreach ($users as $user) {
            // Obtener un número aleatorio de mascotas para agregar a favoritos (entre 1 y 5)
            $randomPets = $pets->random(rand(1, 5))->pluck('pet_id')->toArray();
            $user->favorites()->attach($randomPets);
        }
    }
}
