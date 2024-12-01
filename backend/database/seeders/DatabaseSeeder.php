<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shelter;
use App\Models\User;
use App\Models\Pet;
use App\Models\Favorite;
use App\Models\Adoption;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Llama a otros seeders aquí
        $this->call([
            UserSeeder::class,
            ShelterSeeder::class,
            PetSeeder::class,
            FavoriteSeeder::class,
            AdoptionSeeder::class,
        ]);
    }
}
