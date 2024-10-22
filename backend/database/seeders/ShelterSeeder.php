<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shelter;

class ShelterSeeder extends Seeder
{
    public function run()
    {
        // Crear refugios predeterminados
        Shelter::createDefaultShelter();

        // Puedes agregar más refugios si es necesario
        Shelter::factory()->count(9)->create(); // Si estás usando factories
    }
}
