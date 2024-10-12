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
        return Adoption::create($request->all());
    }

    public function show(Adoption $adoption)
    {
        return $adoption;
    }

    public function update(Request $request, Adoption $adoption)
    {
        $adoption->update($request->all());
        return $adoption;
    }

    public function destroy(Adoption $adoption)
    {
        $adoption->delete();
        return response()->noContent();
    }
}
