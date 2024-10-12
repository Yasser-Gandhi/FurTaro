<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Ruta para obtener el usuario autenticado
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas para la gestión de mascotas
Route::apiResource('pets', 'App\Http\Controllers\PetController');

// Rutas para la gestión de usuarios
Route::apiResource('users', 'App\Http\Controllers\UserController');

// Rutas para la gestión de adopciones
Route::apiResource('adoptions', 'App\Http\Controllers\AdoptionController');

// Rutas para la gestión de refugios
Route::apiResource('shelters', 'App\Http\Controllers\ShelterController');

// Rutas para la gestión de favoritos
Route::apiResource('favorites', 'App\Http\Controllers\FavoriteController');

// Rutas públicas (sin autenticación)
Route::get('/pets/search/{species}', [PetController::class, 'searchBySpecies']);
