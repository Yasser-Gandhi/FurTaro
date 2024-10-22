<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pet;
use App\Models\Shelter;

class PetSeeder extends Seeder
{
    public function run()
    {
        $shelters = Shelter::all();
        $totalPets = 127; 
        $petsPerShelter = intval($totalPets / $shelters->count());

        foreach ($shelters as $shelter) {
            for ($i = 0; $i < $petsPerShelter; $i++) {
                Pet::factory()->create([
                    'shelter_id' => $shelter->shelter_id, // Asigna un shelter_id válido
                ]);
            }
        }

        // Si hay mascotas restantes, distribúyelas aleatoriamente
        $remainingPets = $totalPets % $shelters->count();
        for ($i = 0; $i < $remainingPets; $i++) {
            $randomShelter = $shelters->random();
            Pet::factory()->create([
                'shelter_id' => $randomShelter->shelter_id, // Asigna un shelter_id válido
            ]);
        }
    }
}
