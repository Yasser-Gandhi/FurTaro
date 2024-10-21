<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShelterController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\FavoriteController;

// Ruta principal de la API
Route::get('/', function () {
    return response()->json(['message' => 'API de Adopciones Mascotas']);
});

// Rutas de autenticación (descomentadas si es necesario)
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Agrupación de rutas con prefijo 'api' y middleware de autenticación
// Descomentar si se requiere autenticación para todas las rutas
// Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('shelters', ShelterController::class);
    Route::apiResource('pets', PetController::class);
    Route::apiResource('adoptions', AdoptionController::class);
    Route::apiResource('favorites', FavoriteController::class);
// });

// Otras rutas que no requieren autenticación pueden añadirse aquí
// Route::get('/public-route', [PublicController::class, 'index']);
