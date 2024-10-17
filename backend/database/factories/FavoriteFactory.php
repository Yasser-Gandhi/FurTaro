<?php

namespace Database\Factories;

use App\Models\Favorite;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition()
    {
        return [
            'user_id' => 1, // O un usuario generado aleatoriamente
            'pet_id' => Pet::factory(), // Asegúrate de que esto esté correcto
            'is_favorite' => $this->faker->boolean(),
        ];
    }
}
