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

        $favorite = Favorite::create($validatedData);
        return response()->json($favorite, 201);
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

    public function destroy(Favorite $favorite)
    {
        $favorite->delete();
        return response()->json(null, 204);
    }
}
