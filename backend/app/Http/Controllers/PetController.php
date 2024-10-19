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

    public function show(Pet $pet)
    {
        return $pet;
    }

    public function update(Request $request, Pet $pet)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'species' => 'string|max:50',
            'age' => 'integer',
            'description' => 'string',
            'shelter_id' => 'exists:shelters,shelter_id',
            'adoption_date' => 'nullable|date',
        ]);

        $pet->update($validatedData);
        return response()->json($pet, 200);
    }

    public function destroy(Pet $pet)
    {
        $pet->delete();
        return response()->json(null, 204);
    }
}
