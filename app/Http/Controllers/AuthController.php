<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function index()
    {
        return 'users !!';
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => HASH::make($validatedData['password']),
        ]);

        return response()->json(['user' => $user], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('auth_token');

        return response([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token->plainTextToken
        ]);
    }




    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function user(Request $request)
    {
        return $request->user();
    }
}
