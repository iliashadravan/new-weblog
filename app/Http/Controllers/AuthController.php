<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\AuthController\RegisterRequest;
use App\Http\Requests\AuthController\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => Hash::make($request->password),
        ]);

        return response()->json([
            'user' => $user
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json();
        }

        return response()->json([
            'user' => Auth::user(),
            'token' => $token
        ]);
    }

    public function me()
    {
        return response()->json(Auth::user());
    }
}
