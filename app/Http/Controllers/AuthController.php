<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthController\ForgetPasswordRequest;
use App\Http\Requests\AuthController\UpdateProfileRequest;
use App\Models\User;
use App\Http\Requests\AuthController\RegisterRequest;
use App\Http\Requests\AuthController\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;


class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store(User::IMAGE_PATH, 'public');
        }
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'image'     =>$imagePath,
            'password'  => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        if ($request->hasFile('image')) {
            if (!empty($user->image) && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            $imagePath = $request->file('image')->store(User::IMAGE_PATH, 'public');
            $user->image = $imagePath;
        }

        $user->update($request->only(['firstname', 'lastname', 'phone']));

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!',
            'user'    => $user,

        ]);
    }
    public function forgotPassword(ForgetPasswordRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        $newPassword = Str::random(6);

        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        Mail::to($user->email)->send(new ResetPasswordMail($newPassword));

        return response()->json([
            'success' => true,
            'message' => 'A new password has been sent to your email!'
        ]);
    }
}


