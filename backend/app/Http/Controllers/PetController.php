<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class PetController extends Controller
{
    // Obtiene todos los registros de mascotas
    public function index(Request $request)
    {
        $pets = Pet::all();

        // Obtiene los favoritos del usuario (autenticado o no)
        $favorites = $this->getFavorites($request);

        // Agrega el estado de favorito a cada mascota
        $pets->each(function ($pet) use ($favorites) {
            $pet->is_favorite = in_array($pet->pet_id, $favorites);
        });

        return response()->json($pets, 200);
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
            'status' => 'nullable|in:disponible,adoptado',
        ]);

        $pet = Pet::create($validatedData);
        return response()->json($pet, 201);
    }

    // Obtener una mascota específica
    public function show(Request $request, $pet_id)
    {
        $pet = Pet::find($pet_id);

        if (!$pet) {
            return response()->json(['message' => 'Mascota no encontrada'], 404);
        }

        // Agrega el estado de favorito a la mascota
        $favorites = $this->getFavorites($request);
        $pet->is_favorite = in_array($pet->pet_id, $favorites);

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
            'status' => 'sometimes|in:disponible,adoptado',
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

        // Eliminar registros relacionados en favoritos
        $this->removeFavorite($pet_id);

        try {
            $pet->delete();
            return response()->json(['message' => 'Mascota eliminada correctamente'], 204);
        } catch (\Exception $e) {
            \Log::error('Error al eliminar la mascota: ' . $e->getMessage());
            return response()->json(['message' => 'Error al eliminar la mascota'], 500);
        }
    }

    // Agregar/Eliminar mascota de favoritos
    public function toggleFavorite(Request $request, $pet_id)
    {
        // Verificar si la mascota existe
        $pet = Pet::find($pet_id);
        if (!$pet) {
            return response()->json(['message' => 'Mascota no encontrada'], 404);
        }

        // Obtiene los favoritos actuales del usuario
        $favorites = $this->getFavorites($request);

        // Agrega o elimina la mascota de los favoritos
        if (($key = array_search($pet_id, $favorites)) !== false) {
            unset($favorites[$key]);
            $isFavorite = false;
        } else {
            $favorites[] = $pet_id;
            $isFavorite = true;
        }

        // Guarda los favoritos actualizados
        $this->saveFavorites($request, $favorites);

        return response()->json([
            'message' => 'Favorito actualizado',
            'isFavorite' => $isFavorite
        ]);
    }

    // Obtiene los favoritos del usuario (autenticado o no)
    private function getFavorites(Request $request)
    {
        if (Auth::check()) {
            // Usuario autenticado: obtener favoritos de la base de datos
            return Auth::user()->favorites()->pluck('pet_id')->toArray();
        } else {
            // Usuario no autenticado: obtener favoritos de la cookie
            return json_decode($request->cookie('favorites', '[]'), true);
        }
    }

    // Guarda los favoritos del usuario (autenticado o no)
    private function saveFavorites(Request $request, $favorites)
    {
        if (Auth::check()) {
            // Usuario autenticado: guardar favoritos en la base de datos
            Auth::user()->favorites()->sync($favorites);
        } else {
            // Usuario no autenticado: guardar favoritos en la cookie
            Cookie::queue('favorites', json_encode($favorites), 60 * 24 * 30); // 30 días
        }
    }

    // Elimina una mascota de los favoritos del usuario
    private function removeFavorite($pet_id)
    {
        if (Auth::check()) {
            // Usuario autenticado: eliminar de la base de datos
            Auth::user()->favorites()->detach($pet_id);
        } else {
            // Usuario no autenticado: eliminar de la cookie
            $favorites = $this->getFavorites(request());
            if (($key = array_search($pet_id, $favorites)) !== false) {
                unset($favorites[$key]);
                $this->saveFavorites(request(), $favorites);
            }
        }
    }
}
