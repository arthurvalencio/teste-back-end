<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    public function register(Request $request) {
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'phone' => $request['phone']
        ]);

        return response()->json(['message' => 'Usuário cadastrado com sucesso.'], 201);
    }

    public function login(Request $request) {
        $user = User::where('email', $request['email'])->first();

        if (!$user || !Hash::check($request['password'], $user->password)) {
            return response()->json(['message' => 'Usuário ou senha incorretos.'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        session(['token' => $token]);

        return response()->json([
            'message' => 'Login realizado com sucesso.',
            'token' => $token,
            'redirect_url' => route('home')
        ]);
    }

    public function userEdit(Request $request, $id) {
        $data = $request->all();

        $user = User::findOrFail($id);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);

        return response()->json(['message' => 'Usuário atualizado com sucesso.'], 201);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return redirect()->route('login')->with('message', 'Deslogado com sucesso.');
    }
}
