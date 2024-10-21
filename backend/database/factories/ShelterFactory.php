<?php

namespace Database\Factories;

use App\Models\Shelter;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShelterFactory extends Factory
{
    protected $model = Shelter::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'location' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
        ];
    }
}
