<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Shelter;
use App\Models\Pet;

class PetControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_can_list_pets()
    {
        $response = $this->getJson('/api/pets');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => [
                         'pet_id',
                         'name',
                         'species',
                         'age',
                         'description',
                         'shelter_id',
                         'status',
                         'created_at',
                         'updated_at',
                         'is_favorite',
                     ],
                 ]);
    }

    public function test_can_create_pet()
    {
        $shelter = Shelter::factory()->create();

        $data = [
            'name' => 'Max',
            'species' => 'perro',
            'age' => 3,
            'description' => 'Un perro amigable.',
            'shelter_id' => $shelter->shelter_id,
            'status' => 'disponible',
        ];

        $response = $this->postJson('/api/pets', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('pets', $data);
    }

    public function test_can_show_pet()
    {
        $shelter = Shelter::factory()->create();
        $pet = Pet::factory()->create(['shelter_id' => $shelter->shelter_id]);

        $response = $this->getJson('/api/pets/' . $pet->pet_id);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'pet_id' => $pet->pet_id,
                     'name' => $pet->name,
                 ]);
    }

    public function test_can_update_pet()
    {
        $shelter = Shelter::factory()->create();
        $pet = Pet::factory()->create(['shelter_id' => $shelter->shelter_id]);

        $updatedData = [
            'name' => 'Maximo',
            'species' => 'perro',
            'age' => 4,
            'description' => 'Un perro aún más amigable.',
            'shelter_id' => $shelter->shelter_id,
            'status' => 'disponible',
        ];

        $response = $this->putJson('/api/pets/' . $pet->pet_id, $updatedData);

        $response->assertStatus(200)
                 ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('pets', $updatedData);
    }

    public function test_can_delete_pet()
    {
        $shelter = Shelter::factory()->create();
        $pet = Pet::factory()->create(['shelter_id' => $shelter->shelter_id]);

        $response = $this->deleteJson('/api/pets/' . $pet->pet_id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('pets', ['pet_id' => $pet->pet_id]);
    }
}
