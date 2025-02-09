<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponse;
use App\Http\Requests\AuthController\LoginRequest;
use App\Http\Requests\AuthController\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $request->validated();

        $user = User::create([
            'firstname' => $request->input('firstname'),
            'lastname'  => $request->input('lastname'),
            'email'     => $request->input('email'),
            'phone'     => $request->input('phone'),
            'password'  => Hash::make($request->input('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return ApiResponse::created([
            'user' => $user,
            'access_token' => $token
        ]);
    }
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = JWTAuth::attempt($credentials)) {
            return ApiResponse::unauthorized();
        }

        return ApiResponse::send([
            'user' => auth()->user(),
            'access_token' => $token
        ]);
    }
}
