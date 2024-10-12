<?php

namespace App\Http\Controllers;

use App\Models\Shelter;
use Illuminate\Http\Request;

class ShelterController extends Controller
{
    public function index()
    {
        return Shelter::all();
    }

    public function store(Request $request)
    {
        return Shelter::create($request->all());
    }

    public function show(Shelter $shelter)
    {
        return $shelter;
    }

    public function update(Request $request, Shelter $shelter)
    {
        $shelter->update($request->all());
        return $shelter;
    }

    public function destroy(Shelter $shelter)
    {
        $shelter->delete();
        return response()->noContent();
    }
}
