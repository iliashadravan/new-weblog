<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserController\UserRequest;

class UserController extends Controller
{
    public function updateUserInfo(UserRequest $request, User $user)
    {
        $validated_data = $request->validated();

        $user->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User information updated successfully!',
            'user' => $user
        ]);
    }
}
