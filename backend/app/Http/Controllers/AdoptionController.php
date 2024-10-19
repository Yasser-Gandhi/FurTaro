<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use Illuminate\Http\Request;

class AdoptionController extends Controller
{
    public function index()
    {
        return Adoption::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'pet_id' => 'required|exists:pets,pet_id',
            'adoption_date' => 'required|date',
        ]);

        $adoption = Adoption::create($validatedData);
        return response()->json($adoption, 201);
    }

    public function show(Adoption $adoption)
    {
        return $adoption;
    }

    public function update(Request $request, Adoption $adoption)
    {
        $validatedData = $request->validate([
            'user_id' => 'exists:users,user_id',
            'pet_id' => 'exists:pets,pet_id',
            'adoption_date' => 'date',
        ]);

        $adoption->update($validatedData);
        return response()->json($adoption, 200);
    }

    public function destroy(Adoption $adoption)
    {
        $adoption->delete();
        return response()->json(null, 204);
    }
}
