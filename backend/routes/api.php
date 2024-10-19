<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShelterController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\FavoriteController;

// Ruta para obtener el usuario autenticado
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/', function () {
    return response()->json(['message' => 'API de Adopciones Mascotas']);
});


Route::apiResource('users', UserController::class);
Route::apiResource('shelters', ShelterController::class);
Route::apiResource('pets', PetController::class);
Route::apiResource('adoptions', AdoptionController::class);
Route::apiResource('favorites', FavoriteController::class);
