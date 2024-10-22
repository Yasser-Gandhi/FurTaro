<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\Shelter;
use Illuminate\Database\Eloquent\Factories\Factory;

class PetFactory extends Factory
{
    protected $model = Pet::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Bella', 'Max', 'Charlie', 'Luna', 'Oliver', 'Lucy', 'Daisy', 'Buddy', 'Taro']),
            'species' => $this->faker->randomElement(['perro', 'gato', 'conejo', 'hamster']),
            'age' => $this->faker->numberBetween(1, 25),
            'description' => $this->faker->sentence(),
            'shelter_id' => Shelter::factory(),
            'status' => $this->faker->randomElement(['disponible', 'adoptado']),
        ];
    }
}
