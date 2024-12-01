<?php

namespace Database\Factories;

use App\Models\Favorite;
use App\Models\User;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Crea un usuario si no existe
            'pet_id' => Pet::factory(),   // Crea una mascota si no existe
            'updated_at' => now(),
        ];
    }
}
