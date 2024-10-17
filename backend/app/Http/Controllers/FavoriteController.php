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
        // Validación de los datos de entrada
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'pet_id' => 'required|exists:pets,pet_id',
            'is_active' => 'boolean', // Asegura que is_active sea un booleano
        ]);

        return Favorite::create($validatedData);
    }

    public function show(Favorite $favorite)
    {
        return $favorite;
    }

    public function update(Request $request, Favorite $favorite)
    {
        // Validación de los datos de entrada
        $validatedData = $request->validate([
            'user_id' => 'sometimes|exists:users,user_id',
            'pet_id' => 'sometimes|exists:pets,pet_id',
            'is_active' => 'sometimes|boolean', // Asegura que is_active sea un booleano
        ]);

        $favorite->update($validatedData);
        return $favorite;
    }

    public function destroy(Favorite $favorite)
    {
        $favorite->delete();
        return response()->noContent();
    }
}
