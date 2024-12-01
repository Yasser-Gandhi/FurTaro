<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShelterController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AuthController;

// Ruta principal de la API
Route::get('/', function () {
    return response()->json(['message' => 'API de Adopciones Mascotas']);
});

// Rutas para usuarios
Route::apiResource('users', UserController::class);

// Rutas para refugios
Route::apiResource('shelters', ShelterController::class);

// Rutas para mascotas
Route::apiResource('pets', PetController::class);

// Rutas para adopciones
Route::apiResource('adoptions', AdoptionController::class);

// Rutas para favoritos
Route::prefix('favorites')->group(function () {
    // Para usuarios no logueados (local)
    Route::get('/', [FavoriteController::class, 'index']); // Obtener favoritos locales
    Route::post('/local', [FavoriteController::class, 'storeLocalFavorite']); // Agregar favorito local

    // Para usuarios logueados
    Route::get('/users/{user}', [FavoriteController::class, 'index']); // Obtener favoritos de usuario
    Route::post('/users/{user}', [FavoriteController::class, 'store']); // Agregar favorito de usuario
    Route::get('/{favoriteId}', [FavoriteController::class, 'show']); // Mostrar un favorito específico
    Route::put('/{favoriteId}', [FavoriteController::class, 'update']); // Actualizar un favorito
    Route::delete('/users/{user}/{favoriteId}', [FavoriteController::class, 'destroy']); // Eliminar favorito de usuario
});

// Rutas de autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

