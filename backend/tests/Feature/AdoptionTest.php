<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Pet;

class AdoptionTest extends TestCase
{
    use RefreshDatabase; // Esto asegurará que la base de datos se reinicie para cada prueba

    public function testCreateAdoption()
    {
        // Crear un usuario y una mascota
        $user = User::factory()->create();
        $pet = Pet::factory()->create();

        // Intentar crear una adopción válida
        $response = $this->postJson('/api/adoptions', [
            'user_id' => $user->id,
            'pet_id' => $pet->id,
            'adoption_date' => now()->toISOString(),
        ]);
        dd($response->json());
        $response->assertStatus(201); // Verificar que la adopción se creó
        $this->assertDatabaseHas('adoptions', [
            'user_id' => $user->id,
            'pet_id' => $pet->id,
            'status' => 'active',
        ]);
    }
}
