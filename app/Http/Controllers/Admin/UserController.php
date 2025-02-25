<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserController\UserRequest;

class UserController extends Controller
{
    public function updateUserInfo(UserRequest $request, User $user)
    {
        $user->update([
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'is_active' => $request->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User information was successfully updated.',
            'user'    => $user
        ]);
    }
}
