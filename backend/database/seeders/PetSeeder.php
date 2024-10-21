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

        foreach ($shelters as $shelter) {
            Pet::factory()->create([
                'shelter_id' => $shelter->shelter_id, // Asigna un shelter_id válido
            ]);
        }
    }
}
