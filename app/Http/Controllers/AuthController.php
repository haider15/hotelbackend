<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
    $fields = $request->validate([
        'email' => 'required|string',
        'password' => 'required|string'
    ]);

    // Check email
    $user = User::where('email', $fields['email'])->first();

    // Check password
    if(!$user || !Hash::check($fields['password'], $user->password)) {
        return response([
            'message' => 'Bad creds'
        ], 401);
    }

    // Store user ID in localStorage
    $userId = $user->id;
    session(['userId' => $userId]);

    $token = $user->createToken('myapptoken')->plainTextToken;
    $response = [
        'user' => $user,
        'token' => $token
    ];

    return response()->json([
        'user' => $user,
        'token' => $token,
        'userId' => $user->id // Assurez-vous que l'ID utilisateur est inclus dans la réponse
    ], 201);
}


    function getAllUsers() {
        $users = User::all();
        return $users;
    }
}
