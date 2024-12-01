<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class FavoriteController extends Controller
{
    /**
     * Obtener favoritos de un usuario (autenticado o no).
     *
     * @param Request $request
     * @param int|null $userId ID del usuario (opcional para no autenticados)
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, $userId = null)
    {
        try {
            if ($userId) {
                // Usuario autenticado
                $favorites = Favorite::with('pet')
                    ->where('user_id', $userId)
                    ->get();

                return response()->json([
                    'message' => $favorites->isEmpty() ? 'No se encontraron favoritos para este usuario' : 'Favoritos del usuario recuperados exitosamente',
                    'data' => $favorites
                ], 200);
            } else {
                // Usuario no autenticado (usando favoritos locales)
                $localFavorites = $request->input('favorites', []);

                $pets = Pet::whereIn('favorite_id', $localFavorites)->get(); // Cambiado a 'favorite_id'

                return response()->json([
                    'message' => $pets->isEmpty() ? 'No se encontraron favoritos locales' : 'Favoritos locales recuperados exitosamente',
                    'data' => $pets
                ], 200);
            }
        } catch (\Exception $e) {
            return $this->handleError($e, 'Error al obtener favoritos');
        }
    }

    /**
     * Almacenar un nuevo favorito local (no autenticado).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeLocalFavorite(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'pet_id' => 'required|exists:pets,favorite_id', // Cambiado a 'favorite_id'
            ], [
                'pet_id.required' => 'El ID de la mascota es requerido',
                'pet_id.exists' => 'La mascota seleccionada no existe'
            ]);

            $favorites = $request->session()->get('favorites', []);
            $petId = $validatedData['pet_id'];

            if (in_array($petId, $favorites)) {
                // Eliminar si ya existe
                $favorites = array_diff($favorites, [$petId]);
                $request->session()->put('favorites', $favorites);
                return response()->json([
                    'message' => 'Favorito local eliminado exitosamente',
                    'action' => 'removed'
                ], 200);
            } else {
                // Agregar a favoritos
                $favorites[] = $petId;
                $request->session()->put('favorites', $favorites);
                return response()->json([
                    'message' => 'Favorito local agregado exitosamente',
                    'action' => 'added'
                ], 201);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return $this->handleError($e, 'Error al gestionar favorito local');
        }
    }

    /**
     * Almacenar un nuevo favorito o eliminarlo si ya existe (solo usuarios autenticados).
     *
     * @param Request $request
     * @param int $userId ID del usuario 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $userId)
    {
        try {
            $validatedData = $request->validate([
                'pet_id' => 'required|exists:pets,favorite_id', // Cambiado a 'favorite_id'
            ], [
                'pet_id.required' => 'El ID de la mascota es requerido',
                'pet_id.exists' => 'La mascota seleccionada no existe'
            ]);

            // Verificar límite de favoritos (opcional)
            $favoritesCount = Favorite::where('user_id', $userId)->count();
            if ($favoritesCount >= 50) {
                return response()->json([
                    'message' => 'Has alcanzado el límite máximo de favoritos'
                ], 400);
            }

            $favorite = Favorite::where('user_id', $userId)
                ->where('pet_id', $validatedData['pet_id'])
                ->first();

            if ($favorite) {
                $favorite->delete();
                return response()->json([
                    'message' => 'Favorito eliminado exitosamente',
                    'action' => 'removed'
                ], 200);
            } else {
                $favorite = Favorite::create([
                    'user_id' => $userId,
                    'pet_id' => $validatedData['pet_id'],
                ]);

                return response()->json([
                    'message' => 'Favorito agregado exitosamente',
                    'data' => $favorite,
                    'action' => 'added'
                ], 201);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return $this->handleError($e, 'Error al gestionar favorito');
        }
    }

    /**
     * Mostrar un favorito específico.
     *
     * @param int $favoriteId ID del favorito
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($favoriteId)
    {
        try {
            $favorite = Favorite::with('pet')->find($favoriteId);

            if (!$favorite) {
                return response()->json([
                    'message' => 'Favorito no encontrado'
                ], 404);
            }

            return response()->json([
                'message' => 'Favorito recuperado exitosamente',
                'data' => $favorite
            ], 200);
        } catch (\Exception $e) {
            return $this->handleError($e, 'Error al obtener favorito');
        }
    }

    /**
     * Actualizar un favorito existente.
     *
     * @param Request $request
     * @param int $favoriteId ID del favorito
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $favoriteId)
    {
        try {
            $validatedData = $request->validate([
                'pet_id' => 'required|exists:pets,favorite_id', // Cambiado a 'favorite_id'
            ]);

            $favorite = Favorite::find($favoriteId);

            if (!$favorite) {
                return response()->json([
                    'message' => 'Favorito no encontrado'
                ], 404);
            }

            // Verificar si el usuario autenticado es el propietario del favorito
            if ($favorite->user_id !== auth()->id()) {
                return response()->json([
                    'message' => 'No tienes permiso para actualizar este favorito'
                ], 403); 
            }

            $favorite->update($validatedData);

            return response()->json([
                'message' => 'Favorito actualizado exitosamente',
                'data' => $favorite
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return $this->handleError($e, 'Error al actualizar el favorito'); 
        }
    }

    /**
     * Eliminar un favorito.
     *
     * @param int $favoriteId ID del favorito
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($favoriteId)
    {
        try {
            $favorite = Favorite::find($favoriteId);

            if (!$favorite) {
                return response()->json([
                    'message' => 'Favorito no encontrado'
                ], 404);
            }

            // Verificar si el usuario autenticado es el propietario del favorito
            if ($favorite->user_id !== auth()->id()) {
                return response()->json([
                    'message' => 'No tienes permiso para eliminar este favorito'
                ], 403); 
            }

            $favorite->delete();

            return response()->json([
                'message' => 'Favorito eliminado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return $this->handleError($e, 'Error al eliminar el favorito');
        }
    }

    /**
     * Manejar errores de manera centralizada.
     *
     * @param \Exception $e La excepción que se produjo
     * @param string $message Mensaje de error personalizado
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleError(\Exception $e, $message = 'Error en la solicitud') {
        Log::error($message . ': ' . $e->getMessage());
        return response()->json([
            'message' => $message,
            'error' => $e->getMessage()
        ], 500);
    }
}
