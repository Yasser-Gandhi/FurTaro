<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        return Favorite::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'pet_id' => 'required|exists:pets,pet_id',
        ]);

        // Verificar si ya existe el favorito
        $favorite = Favorite::where('user_id', $validatedData['user_id'])
            ->where('pet_id', $validatedData['pet_id'])
            ->first();

        if ($favorite) {
            // Si ya existe, eliminarlo (quitar el favorito)
            $favorite->delete();
            return response()->json(['message' => 'Favorito eliminado'], 204);
        } else {
            // Si no existe, crear el favorito (añadir a favoritos)
            $favorite = Favorite::create($validatedData);
            return response()->json($favorite, 201);
        }
    }

    public function show(Favorite $favorite)
    {
        return $favorite;
    }

    public function update(Request $request, Favorite $favorite)
    {
        $validatedData = $request->validate([
            'user_id' => 'exists:users,user_id',
            'pet_id' => 'exists:pets,pet_id',
        ]);

        $favorite->update($validatedData);
        return response()->json($favorite, 200);
    }

    public function destroy($favorite_id)
    {
        $favorite = Favorite::find($favorite_id);

        if (!$favorite) {
            return response()->json(['message' => 'Favorito no encontrado'], 404);
        }

        try {
            $favorite->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            \Log::error('Error al eliminar el favorito: ' . $e->getMessage());
            return response()->json(['message' => 'Error al eliminar el favorito'], 500);
        }
    }
}
