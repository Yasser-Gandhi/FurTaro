<?php

namespace App\Http\Controllers;

use App\Models\Shelter;
use Illuminate\Http\Request;

class ShelterController extends Controller
{
    // Método para obtener todos los refugios
    public function index()
    {
        return response()->json(Shelter::all(), 200);
    }

    // Método para crear un nuevo refugio
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'location' => 'required|string|max:255',
            'phone_number' => 'required|string|max:50',
        ]);

        $shelter = Shelter::create($validatedData);
        return response()->json($shelter, 201);
    }

    // Método para obtener un refugio específico por su ID
    public function show(Shelter $shelter)
    {
        return response()->json($shelter, 200);
    }

    // Método para actualizar un refugio existente
    public function update(Request $request, Shelter $shelter)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email',
            'location' => 'sometimes|string|max:255',
            'phone_number' => 'sometimes|string|max:50',
        ]);

        // Actualizar los datos del refugio
        $shelter->update($validatedData);
        return response()->json($shelter, 200);
    }

    // Método para eliminar un refugio
    public function destroy(Shelter $shelter)
    {
        try {
            $shelter->delete();
            return response()->json(['message' => 'Refugio eliminado correctamente'], 204);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el refugio'], 500);
        }
    }
}
