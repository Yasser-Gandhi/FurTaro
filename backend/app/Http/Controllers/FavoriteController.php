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
        return Favorite::create($request->all());
    }

    public function show(Favorite $favorite)
    {
        return $favorite;
    }

    public function update(Request $request, Favorite $favorite)
    {
        $favorite->update($request->all());
        return $favorite;
    }

    public function destroy(Favorite $favorite)
    {
        $favorite->delete();
        return response()->noContent();
    }
}
