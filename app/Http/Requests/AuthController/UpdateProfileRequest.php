<?php

namespace App\Http\Requests\AuthController;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'phone'     => 'nullable|string|max:20|unique:users,phone,' . auth()->id(),
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
