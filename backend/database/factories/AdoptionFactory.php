<?php

namespace Database\Factories;

use App\Models\Adoption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Adoption>
 */
class AdoptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Adoption::class;

    public function definition(): array
    {
        return [
            'pet_id' => \App\Models\Pet::factory(),
            'user_id' => \App\Models\User::factory(),
            'status' => 'pending',
        ];
    }
}
