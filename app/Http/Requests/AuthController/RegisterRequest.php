<?php

namespace App\Http\Requests\AuthController;

use App\Http\Requests\Request;

class RegisterRequest extends Request
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'phone'     => 'required|unique:users,phone|regex:/^09[0-9]{9}$/',
            'password'  => 'required|string|min:6',
            'image'     =>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email'     => 'nullable|email|unique:users,email',
        ];
    }
}
