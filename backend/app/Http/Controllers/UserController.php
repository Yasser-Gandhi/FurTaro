<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Usando Hash
            'phone_number' => $request->phone_number
        ]);

        return response()->json($user, 201);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'phone_number' => 'sometimes|required|string',
            'password' => 'sometimes|required|string|min:8',
        ]);

        $user = User::findOrFail($id);
        
        // Actualizar contraseña solo si se proporciona
        if ($request->filled('password')) {
            $request->merge(['password' => Hash::make($request->password)]); // Usando Hash
        }

        // Actualizar solo los campos que han sido validados
        $user->update($request->only(['name', 'email', 'phone_number', 'password']));

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }

    // Método para el inicio de sesión
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            return response()->json($user);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Método para el registro (signup)
    public function signup(Request $request)
    {
        return $this->store($request); // Reutiliza el método store para crear el usuario
    }
}
