<?php

namespace Database\Factories;

use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Pet::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'species' => $this->faker->word,
            'age' => $this->faker->numberBetween(1, 25),
            'description' => $this->faker->sentence,
            'shelter_id' => \App\Models\Shelter::factory(),
        ];
    }
}
