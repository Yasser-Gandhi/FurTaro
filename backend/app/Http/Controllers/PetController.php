<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    // Obtener todos los registros de mascotas
    public function index()
    {
        return response()->json(Pet::all(), 200);
    }

    // Almacenar una nueva mascota
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:50',
            'age' => 'required|integer',
            'description' => 'required|string',
            'shelter_id' => 'required|exists:shelters,shelter_id',
            'adoption_date' => 'nullable|date',
        ]);

        $pet = Pet::create($validatedData);
        return response()->json($pet, 201);
    }

    // Obtener una mascota específica
    public function show($pet_id)
    {
        $pet = Pet::find($pet_id);

        if (!$pet) {
            return response()->json(['message' => 'Mascota no encontrada'], 404);
        }

        return response()->json($pet, 200);
    }

    // Actualizar una mascota existente
    public function update(Request $request, $pet_id)
    {
        $pet = Pet::find($pet_id);

        if (!$pet) {
            return response()->json(['message' => 'Mascota no encontrada'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'species' => 'sometimes|string|max:50',
            'age' => 'sometimes|integer',
            'description' => 'sometimes|string',
            'shelter_id' => 'sometimes|exists:shelters,shelter_id',
            'adoption_date' => 'sometimes|nullable|date',
        ]);

        $pet->update($validatedData);
        return response()->json($pet, 200);
    }

    // Eliminar una mascota
    public function destroy($pet_id)
    {
        $pet = Pet::find($pet_id);
    
        if (!$pet) {
            return response()->json(['message' => 'Mascota no encontrada'], 404);
        }
    
        // Eliminar registros relacionados en favorites
        \DB::table('favorites')->where('pet_id', $pet_id)->delete();
    
        try {
            $pet->delete();
            return response()->json(['message' => 'Mascota eliminada correctamente'], 204);
        } catch (\Exception $e) {
            \Log::error('Error al eliminar la mascota: ' . $e->getMessage());
            return response()->json(['message' => 'Error al eliminar la mascota'], 500);
        }
    }
}    