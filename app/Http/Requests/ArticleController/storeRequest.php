<?php

namespace App\Http\Requests\ArticleController;

use App\Http\Requests\Request;

class storeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required',
            'body'        => 'required|min:5',
            'categories'  => 'nullable|array',
            'categories.*'=> 'exists:categories,id',
        ];
    }
}
