<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);
        Log::info('User created with user_id: ' . $user->user_id);

        return response()->json(['user_id' => $user->user_id] + $user->toArray(), 201);
    }

    public function show($user_id)
    {
        $user = User::where('user_id', $user_id)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user, 200);
    }

    public function update(Request $request, $user_id)
    {
        $user = User::where('user_id', $user_id)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        try {
            $validatedData = $request->validate([
                'name' => 'sometimes|string|max:255',
                'phone_number' => 'sometimes|string',
                'email' => 'sometimes|string|email|unique:users,email,' . $user->user_id . ',user_id', // Cambiado aquí
                'password' => 'sometimes|string|min:8',
            ]);

            if (isset($validatedData['password'])) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            }

            $user->update($validatedData);
            
            return response()->json(['user_id' => $user->user_id] + $user->toArray(), 200);
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return response()->json(['message' => 'Error al actualizar el usuario', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($user_id)
    {
        $user = User::where('user_id', $user_id)->first();
    
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    
        $user->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente'], 204);
    }
}