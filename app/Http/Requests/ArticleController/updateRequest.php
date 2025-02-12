<?php

namespace App\Http\Requests\ArticleController;

use Illuminate\Foundation\Http\FormRequest;

class updateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title'       => 'required|min:3|max:50',
            'body'        => 'required',
            'categories'  => 'nullable|array',
            'categories.*'=> 'exists:categories,id',
        ];
    }
}
