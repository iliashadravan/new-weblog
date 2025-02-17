<?php

namespace App\Http\Requests\AuthController;

use App\Http\Requests\Request;

class UpdateProfileRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'password'  => 'required|string|min:6',
            'phone'     => 'nullable|string|max:20|unique:users,phone,' . auth()->id(),
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
