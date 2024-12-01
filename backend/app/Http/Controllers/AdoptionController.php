<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\Pet; 
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdoptionController extends Controller
{
    public function index(): JsonResponse
    {
        Log::info('Obteniendo todas las adopciones.');
    
        $adoptions = DB::table('adoptions')
            ->join('pets', 'adoptions.pet_id', '=', 'pets.pet_id')
            ->join('users', 'adoptions.user_id', '=', 'users.user_id')
            ->select(
                'adoptions.adoption_id',
                'pets.pet_id',
                'pets.name AS pet_name',
                'users.user_id',
                'users.name AS user_name',
                'adoptions.status',
                'adoptions.adoption_date',
                'adoptions.end_date',
                'adoptions.end_reason'
            )
            ->get();
    
        // Transformar los datos para que sean más accesibles
        $formattedAdoptions = $adoptions->map(function ($adoption) {
            return [
                'adoption_id' => $adoption->adoption_id,
                'description' => "Adopción de {$adoption->pet_name}",
                'pet' => [
                    'id' => $adoption->pet_id,
                    'name' => $adoption->pet_name,
                ],
                'user' => [
                    'id' => $adoption->user_id,
                    'name' => $adoption->user_name,
                ],
                'status' => $adoption->status,
                'adoption_date' => $adoption->adoption_date,
                'end_date' => $adoption->end_date,
                'end_reason' => $adoption->end_reason,
            ];
        });
    
        return response()->json($formattedAdoptions, 200);
    }
    


    public function store(Request $request): JsonResponse
    {
        Log::info('Intentando crear una nueva adopción.');

        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'pet_id' => 'required|exists:pets,id',
            'adoption_date' => 'required|date',
        ]);

        Log::info('Datos validados para la adopción.', ['data' => $validatedData]);

        $pet = Pet::find($validatedData['pet_id']);

        if (!$pet) {
            Log::warning('Animal no encontrado.', ['pet_id' => $validatedData['pet_id']]);
            return response()->json(['message' => 'Animal no encontrado.'], 404);
        }

        Log::info('Estado del animal antes de la adopción.', ['pet_id' => $pet->id, 'status' => $pet->status]);

        if (!Adoption::canAdopt($pet->id)) {
            Log::warning('Intento de adoptar un animal que ya tiene una adopción activa.', ['pet_id' => $pet->id]);
            return response()->json(['message' => 'Este animal ya tiene una adopción activa.'], 400);
        }

        try {
            DB::beginTransaction();
            $adoption = Adoption::create($validatedData);
            $pet->status = 'adopted';
            $pet->save();
            DB::commit();
            Log::info('Adopción creada con éxito.', ['adoption_id' => $adoption->id]);
            return response()->json($adoption, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear la adopción.', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error al crear la adopción.'], 500);
        }
    }

    public function returnPet($adoption_id): JsonResponse
    {
        Log::info('Intentando devolver el animal.', ['adoption_id' => $adoption_id]);

        $adoption = Adoption::find($adoption_id);

        if (!$adoption) {
            Log::warning('Adopción no encontrada.', ['adoption_id' => $adoption_id]);
            return response()->json(['message' => 'Adopción no encontrada'], 404);
        }

        if ($adoption->status !== 'active') {
            Log::warning('Intento de devolver una adopción que no está activa.', ['adoption_id' => $adoption_id]);
            return response()->json(['message' => 'Esta adopción ya no está activa.'], 400);
        }

        try {
            DB::beginTransaction();
            $adoption->endAdoption('Devolución del animal');

            $pet = Pet::find($adoption->pet_id);
            $pet->status = 'available';
            $pet->save();

            DB::commit();
            Log::info('Animal devuelto con éxito.', ['adoption_id' => $adoption_id]);
            return response()->json(['message' => 'El animal ha sido devuelto con éxito.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al devolver el animal.', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error al devolver el animal.'], 500);
        }
    }

    public function show(Adoption $adoption): JsonResponse
    {
        Log::info('Obteniendo detalles de la adopción.', ['adoption_id' => $adoption->id]);
        return response()->json($adoption, 200);
    }

    public function update(Request $request, Adoption $adoption): JsonResponse
    {
        Log::info('Intentando actualizar la adopción.', ['adoption_id' => $adoption->id]);

        $validatedData = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'pet_id' => 'sometimes|exists:pets,id',
            'adoption_date' => 'sometimes|date',
            'status' => 'sometimes|in:active,returned,completed',
            'end_date' => 'sometimes|date|nullable',
            'end_reason' => 'sometimes|string|nullable',
        ]);

        $adoption->update($validatedData);
        Log::info('Adopción actualizada con éxito.', ['adoption_id' => $adoption->id]);
        return response()->json($adoption, 200);
    }

    public function destroy($adoption_id): JsonResponse
    {
        Log::info('Intentando eliminar la adopción.', ['adoption_id' => $adoption_id]);

        $adoption = Adoption::find($adoption_id);

        if (!$adoption) {
            Log::warning('Adopción no encontrada para eliminación.', ['adoption_id' => $adoption_id]);
            return response()->json(['message' => 'Adopción no encontrada'], 404);
        }

        try {
            $adoption->delete();
            Log::info('Adopción eliminada con éxito.', ['adoption_id' => $adoption_id]);
            return response()->json(null, 204);
        } catch (\Exception $e) {
            Log::error('Error al eliminar la adopción.', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error al eliminar la adopción'], 500);
        }
    }
}
