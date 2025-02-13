<?php

namespace App\Http\Requests\ArticleController;

use App\Http\Requests\Request;

class updateRequest extends Request
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
