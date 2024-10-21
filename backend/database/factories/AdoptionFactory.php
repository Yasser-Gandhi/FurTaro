<?php

namespace Database\Factories;

use App\Models\Adoption;
use App\Models\User;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdoptionFactory extends Factory
{
    protected $model = Adoption::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Crea un usuario si no existe
            'pet_id' => Pet::factory(),   // Crea una mascota si no existe
            'adoption_date' => $this->faker->dateTimeThisDecade(), // Fecha aleatoria en la última década
            'status' => 'active', // Estado por defecto
            'end_date' => null,   // No hay fecha de finalización al crear una adopción
            'end_reason' => null, // No hay razón de finalización al crear una adopción
        ];
    }
}
