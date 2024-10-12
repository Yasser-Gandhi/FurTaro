<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index()
    {
        return Pet::all();
    }

    public function store(Request $request)
    {
        return Pet::create($request->all());
    }

    public function show(Pet $pet)
    {
        return $pet;
    }

    public function update(Request $request, Pet $pet)
    {
        $pet->update($request->all());
        return $pet;
    }

    public function destroy(Pet $pet)
    {
        $pet->delete();
        return response()->noContent();
    }

    // Método para buscar mascotas
    // Se deben agregar a la lógica los siguientes términos relevantes para la búsqueda de adopción:
    // tamaño, temperamento, color, y otros términos relevantes.

    public function search(Request $request)
    {
        // Validar los parámetros de búsqueda
        $request->validate([
            'species' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'description' => 'nullable|string|max:500',
        ]);

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

        // Retornar la respuesta
        return response()->json($pets);
    }

    // Método para buscar mascotas por especie usando wildcard
    public function searchBySpecies($species)
    {
        // Filtrar mascotas por especie
        $pets = Pet::where('species', 'LIKE', '%' . $species . '%')->get();
    
        // Comprobar si se encontraron resultados
        if ($pets->isEmpty()) {
            return response()->json(['message' => 'No se encontraron mascotas.'], 404);
        }
    
        // Retornar la respuesta
        return response()->json($pets);
    }
    
}
