<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    // Método para obtener todas las mascotas
    public function index()
    {
        try {
            return response()->json(Pet::all(), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocurrió un error al recuperar todas las mascotas.'], 500);
        }
    }

    // Método para almacenar una nueva mascota
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'description' => 'nullable|string|max:500',
            'shelter_id' => 'required|exists:shelters,id',
        ]);

        try {
            // Crear y retornar la nueva mascota
            $pet = Pet::create($request->all());
            return response()->json($pet, 201); // Código 201 para creación exitosa
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocurrió un error al crear la mascota.'], 500);
        }
    }

    // Método para mostrar una mascota específica
    public function show($pet_id)
    {
        try {
            // Intentar encontrar la mascota por pet_id
            $pet = Pet::findOrFail($pet_id);
            return response()->json($pet, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Mascota no encontrada.'], 404);
        } catch (\Exception $e) {
            \Log::error('Error al mostrar mascota: ' . $e->getMessage());
            return response()->json(['message' => 'Ocurrió un error.'], 500);
        }
    }
    

    // Método para actualizar una mascota existente
    public function update(Request $request, Pet $pet)
    {
        // Validar los datos de entrada para la actualización
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'species' => 'sometimes|required|string|max:255',
            'age' => 'sometimes|required|integer|min:0',
            'description' => 'sometimes|nullable|string|max:500',
            'shelter_id' => 'sometimes|required|exists:shelters,id',
        ]);

        try {
            // Actualizar y retornar la mascota
            $pet->update($request->all());
            return response()->json($pet, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocurrió un error al actualizar la mascota.'], 500);
        }
    }

    // Método para eliminar una mascota
    public function destroy(Pet $pet)
    {
        try {
            $pet->delete();
            return response()->noContent(); // Retorna un 204 No Content
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocurrió un error al eliminar la mascota.'], 500);
        }
    }

    // Método para buscar mascotas con múltiples criterios
    public function search(Request $request)
    {
        // Validar los parámetros de búsqueda
        $request->validate([
            'species' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'description' => 'nullable|string|max:500',
        ]);

        try {
            // Obtener los parámetros de búsqueda
            $species = $request->input('species');
            $age = $request->input('age');
            $description = $request->input('description');

            // Construir la consulta
            $query = Pet::query();

            // Filtrar por especie
            if ($species) {
                $query->where('species', 'LIKE', '%' . $species . '%');
            }

            // Filtrar por edad
            if ($age) {
                $query->where('age', $age);
            }

            // Filtrar por descripción
            if ($description) {
                $query->where('description', 'LIKE', '%' . $description . '%');
            }

            // Obtener los resultados
            $pets = $query->get();

            return response()->json($pets, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocurrió un error al buscar mascotas.'], 500);
        }
    }

    // Método para buscar mascotas por especie usando wildcard
    public function searchBySpecies($species)
    {
        try {
            // Filtrar mascotas por especie
            $pets = Pet::where('species', 'LIKE', '%' . $species . '%')->get();

            // Comprobar si se encontraron resultados
            if ($pets->isEmpty()) {
                return response()->json(['message' => 'No se encontraron mascotas.'], 404);
            }

            return response()->json($pets, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocurrió un error al buscar por especie.'], 500);
        }
    }
}
