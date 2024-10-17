<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Ruta para obtener el usuario autenticado
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function () {
    return response()->json(['message' => 'API de Adopciones Mascotas']);
});

// Rutas para la gestión de mascotas
Route::apiResource('pets', App\Http\Controllers\PetController::class); // Cambié la sintaxis

// Rutas para la gestión de usuarios
Route::apiResource('users', App\Http\Controllers\UserController::class);

// Rutas para la gestión de adopciones
Route::apiResource('adoptions', App\Http\Controllers\AdoptionController::class);

// Rutas para la gestión de refugios
Route::apiResource('shelters', App\Http\Controllers\ShelterController::class);

// Rutas para la gestión de favoritos
Route::apiResource('favorites', App\Http\Controllers\FavoriteController::class);

// Rutas públicas (sin autenticación)
Route::get('/pets/search/{species}', [App\Http\Controllers\PetController::class, 'searchBySpecies']);
